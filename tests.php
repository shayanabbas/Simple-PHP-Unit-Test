
<?php
// Lets include our Test Library
include_once('classes/Test.class.php');
// Lets include our Class to test it
include_once('classes/Data.class.php');

$test = new Test();
$data = new Data();

/**
	 * Show test results with different inputs
	 * @param class $class class of which method to be tested
	 * @param string $method name of method of the class
	 * @param string $expectedOutput output that is expected 
	 * @param int $numberOfParams number of params in method. Default: 1
	 * @param array $additionalData additional data to test. (optional)
**/

$test->result( $data, 'validateFileEncoding', 'boolean', '1' );

$test->result( $data, 'validateFileDelimiter', 'boolean', '2' );

$test->result( $data, 'validateDate', 'boolean', '2' );

$test->result( $data, 'getFileHeader', 'boolean', '1' );

$test->result( $data, 'getFileData', 'boolean', '2' );

$test->result( $data, 'validateFileData', 'boolean', '3' );

/**
 	 * ParamFormat eg.
	 * array(array("string" => "This is a string data."),
	 *		 array("int" => 1),
	 *		 array("float" => 2.0),
	 *		 array("array" => array()),
	 *		 array("bool" => false)
	 * 		);
 	 *
	 * 	For additionalData values, Following are the variable types
	 *		"boolean"
	 *		"integer"
	 *		"double" (for historical reasons "double" is returned in case of a float, and not simply "float")
	 *		"string"
	 *		"array"
	 *		"object"
	 *		"resource"
	 *		"resource (closed)" as of PHP 7.2.0
	 *		"NULL"
	 *		"unknown type"
**/

$additionalData = array(array('string' => 'Check these characters $$ %% ** {}',
						array('object' => $data))
						);
$test->result( $data, 'isFloat', 'boolean', '1', $additionalData );


?>
</pre>