<?php
/**
 * This is a SAMPLE classes provided with this package to test the library
 * This class is used for getting data from CSV file
 *
 * @package Simple-PHP-Unit-Test
 * @author Shayan Abbas (github: shayanabbas | shayanabbas@outlook.com)
 * @version 1.0
 * @copyright 2018
 */
class Data 
{
	/**
	 * Validate CSV File encoding
	 * @param string $file location of the file
	 * @return bool 
	 */
	function validateFileEncoding( $file ) {

		if( !@file_exists( $file ) ) 
			return false;
		if( mb_check_encoding( file_get_contents( $file ), 'UTF-8') )
			return true;
		else
			return false;

	}

	/**
	 * Validate CSV File delimiter
	 * @param string $file location of the file
	 * @param int $checkLines number of lines to check 
	 * @return bool 
	 */
	function validateFileDelimiter( $file, $checkLines = 2 ) {

		if( !@file_exists( $file ) ) 
			return false;

		$file = new SplFileObject( $file );
		$delimiters = array(
		  ',',
		  '\t',
		  ';',
		  '|',
		  ':'
		);
		$data = array();
		$i = 0;
		while( $file->valid() && $i <= $checkLines ) {
		    $line = $file->fgets();
		    foreach ( $delimiters as $delimiter ){
		        $regExp = '/[' . $delimiter . ']/';
		        $fields = preg_split( $regExp, $line );
		        if( count( $fields ) > 1 ) {
		            if( !empty( $data[ $delimiter ] ) )
		                $data[ $delimiter ]++;
		            else
		                $data[ $delimiter ] = 1;
		        }
		    }
		   $i++;
		}
		if(count($data)==0)
			return false;
		else
		$data = array_keys( $data, max( $data ) );

		if( $data[ 0 ] == '\t' )
			return true;
		else
			return false;
	}

	/**
	 * Validate Date format in csv
	 * @param string $date date from csv data
	 * @param string $format check date against format
	 * @return bool 
	 */
	function validateDate( $date, $format = 'Y-m-d H:i:s.v' )
	{	
		if( is_string( $date ) ) {
			if (strtotime($date) === false) {
				return false;
			} else {
				//if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",(!is_array($date))? $date : null) ) {
				if ( is_array( $date ) )  {
					return false;
				} else {
					$d = new DateTime($date);
			    	return $d && $d->format($format) == $date;
				}
			} 
		} else {
			return false;
		}
	}

	/**
	 * Get column header of a CSV file
	 * @param string $file location of the file
	 * @return array 
	 */
	function getFileHeader( $file ) {

		if( !@file_exists( $file ) ) 
			return false;
		$lines = explode( "\n", file_get_contents( $file ) );
		$headers = str_getcsv( array_shift( $lines ) );
		$headers = explode( "\t", $headers[0] );

		return $headers;
	}

	/**
	 * Get data except heard from a CSV file
	 * @param string $file location of the file
	 * @param array $filter Array containing the necessary params.
	 *    $filter = [
	 *      'projectId'  => (string) Project Id. Default: NULL.
	 *      'sortByDate' => (string) Sort by date. Default: ASC.
	 *    ]
	 * @return array 
	 */
	function getFileData( $file, $filter = array( 'projectId' => NULL, 'sortByDate' => 'ASC' ) ) {

		if( !@file_exists( $file ) ) 
			return false;

		//getting header values
		$header = $this->getFileHeader( $file );

		//getting count of total coloms in the file
		$headerCount = count( $header );

		//getting each cell data in array
		if ( ( $handle = fopen( $file, "r" ) ) !== false) {
		    $filesize = filesize($file);
		    $firstRow = true;
		    $aData = array();
		    while ( ( $data = fgetcsv( $handle, $filesize, ";" ) ) !== false ) {
		        if( $firstRow ) {
		            $firstRow = false;
		        } else {
		            for( $i = 0; $i < count( $data ); $i++ ) {
		                $aData[] = explode( "\t", $data[ $i ] ); //$data[$i];
		            }
		        }
		    }
		    fclose($handle);
		}

		//checking if data is valid by counting cells of each row
		foreach( $aData AS $data ) {
			if( $headerCount == count( $data) ) {
				$i = 0;
				foreach ( $data AS $cellData ) {
					$bData[ $header[ $i ] ][] = $cellData;
					$i++;
				}
			}
		}

		if( !isset( $bData ) )
			return array( 'type' => 'error', 'message' => 'Seems like file doesn\'t have records.');

		//checking Dates (Start date) format
		foreach( $bData['Start date'] AS $key => $date ) {
			(int) $rowNumber = $key;
			$rowNumber += 1;
			if( !$this->validateDate($date) )
				return array( 'type' => 'error', 'message' => 'File has incorrect date format in row ' . $rowNumber . '.');
		}

		//checking money (Savings amount) format
		foreach( $bData['Savings amount'] AS $key => $amount ) {
			(int) $rowNumber = $key;
			$rowNumber += 1;
			$amountFloat = $amount;
			settype($amountFloat, "float"); 
			settype($amountFloat, "string"); 

			if( ( $amount != $amountFloat ) AND ( $amount == "NULL" OR $amount == "" ) ) {
				$bData['Savings amount'][ $key ] = "";
			} elseif ( !$this->isFloat( $amount ) ) {
				return array( 'type' => 'error', 'message' => 'File must have upto 6 decimal amount and correct format in row ' . $rowNumber . '.');
			} 

		}

		//setting currency "NULL" value to an empty string
		foreach( $bData['Currency'] AS $key => $currency ) {
			if($currency == "NULL")
				$bData['Currency'][ $key ] = "";
		}

		return $bData;
	}


	/**
	 * Validate if specific data exists in the colom or not
	 * @param string $colomName colom name from csv header
	 * @param array $data contain params to check in the colom
	 * @param array $fileData data from csv to check against
	 * @return bool 
	 */
	function validateFileData( $colomName, $data = array(), $fileData = array() ) {

		if( !is_array( $data ) AND !is_array( $fileData ) )
			return false;
		if(  !is_string( $colomName ) )
			return false;

		if( !( ( count( $fileData ) == 2 ) AND in_array( "error", $fileData ) ) ) {
			
			//checking if there is some other data in the colom or not
			foreach( $fileData[ $colomName ] AS $key => $colomValue ) {
				if( !in_array( $colomValue, $data ) )
					return false;
			}

		} else {
			return false;
		}

		return true;

	}

	/**
	 * If string value from csv is float or not
	 * @param string $val value from csv money field
	 * @return bool 
	 */
	function isFloat($val) 
	{ 	
		if(  !is_string( $val ) )
			return false;
		return (bool) preg_match('/^(?:[1-9]{1}\d*|0)\.\d{6}$/', $val);

	} 


}