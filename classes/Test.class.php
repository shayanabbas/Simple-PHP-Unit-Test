<?php
/**
 * This class is used for getting data from CSV file
 *
 * @package Simple-PHP-Unit-Test
 * @author Shayan Abbas (github: shayanabbas | shayanabbas@outlook.com)
 * @version 1.0
 * @copyright 2018
 */
class Test 
{	

	/**
	 * Show test results with different inputs
	 * @param class $class class of which method to be tested
	 * @param string $method name of method of the class
	 * @param string $expectedOutput output that is expected 
	 * @param int $numberOfParams number of params in method. Default: 1
	 * @param array $additionalData additional data to test. (optional)
	 * 				ParamFormat eg.
	 *  			array(array("string" => "This is a string data."),
	 *					  array("int" => 1),
	 *					  array("float" => 2.0),
	 *					  array("array" => array()),
	 *					  array("bool" => false));
 	 *
	 * 				For additionalData values, Following are the variable types
	 *			  	"boolean"
	 *				"integer"
	 *				"double" (for historical reasons "double" is returned in case of a float, and not simply "float")
	 *				"string"
	 *				"array"
	 *				"object"
	 *				"resource"
	 *				"resource (closed)" as of PHP 7.2.0
	 *				"NULL"
	 *				"unknown type"
	 * @return mixed 
	 */
	function result( $class, $method, $expectedOutput, $numberOfParams = 1,  $additionalData = array() ) {

		$data = array(array("string" => "This is a string data."),
					  array("int" => 1),
					  array("int" => 0),
					  array("float" => 2.0),
					  array("array" => array()),
					  array("boolean" => true),
					  array("boolean" => false));

		echo '<h2>Testing ' . get_class($class) . '->' . $method . '()</h2>';
		echo '<br />';
		echo '<strong>Expected Output:</strong> ' . $expectedOutput;
		echo '<br />';
		echo '<br />';

		print_r('<pre>');

		//Let's start checking different values in class method
		$i = 0;
		foreach ($data as $key => $value) {
			$args = array();
			foreach ($data[$key] as $key => $value) {
				$dataVal = $value;
			}
			for($j=0; $j<$numberOfParams; $j++) {
				$args[] = $dataVal;
			}

			echo '<br />';
			echo '<strong>Input Type:</strong> ' . $key;
			echo '<br />';
			echo '<strong>Input Data:</strong> ';
			echo (is_array($value)) ? var_dump($value) : $value;
			echo '<br />';
			echo '<strong>Result:</strong> ';
			echo $result = gettype(call_user_func_array(array($class, $method), $args));
			echo '<br />';
			if($result == $expectedOutput)
				echo '<strong style="color:green;">PASS</strong>';
			else
				echo '<strong style="color:red;">FAIL</strong>';
			echo '<br />';

			$i++;
		}

		//Let's check with additional data if provided
		if(count($additionalData) > 0) {
			$i = 0;
			foreach ($additionalData as $key => $value) {
				$args = array();
				foreach ($additionalData[$key] as $key => $value) {
					$dataVal = $value;
				}
				for($j=0; $j<$numberOfParams; $j++) {
					$args[] = $dataVal;
				}


				echo '<br />';
				echo '<strong>Input Type:</strong> ' . $key;
				echo '<br />';
				echo '<strong>Input Data:</strong> ';
				echo (is_array($value)) ? var_dump($value) : $value;
				echo '<br />';
				echo '<strong>Result:</strong> ';
				echo $result = gettype(call_user_func_array(array($class, $method), $args));
				echo '<br />';
				if($result == $expectedOutput)
					echo '<strong style="color:green;">PASS</strong>';
				else
					echo '<strong style="color:red;">FAIL</strong>';
				echo '<br />';

				$i++;
			}
		}
	}


}