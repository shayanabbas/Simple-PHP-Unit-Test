# Simple-PHP-Unit-Test
Simple-PHP-Unit-Test library generate a simple unit test report after testing your methods with different types of variables and inputs.

# Requirement
PHP v7

# How to use?
Include and initialize the library on your file.
include_once('classes/Test.class.php');
$test = new Test();

Include and initialize your class to test it's method.
As for a reference I have added a small Data class in classes/Data.class.php
So we are going to use it for reference, you can also check/run tests.php file

include_once('classes/Data.class.php');
$data = new Data();

Now were going to test $data->validateFileEncoding() method
Check the following for parameter details

* @param class $class class of which method to be tested
* @param string $method name of method of the class
* @param string $expectedOutput output that is expected 
* @param int $numberOfParams number of params in method. Default: 1
* @param array $additionalData additional data to test. (optional)
   
Now we will test our method.

$test->result( $data, 'validateFileEncoding', 'boolean', '1' );

Once Run it will show results like following and also check unit_test_results.html


Testing Data->validateFileEncoding()

Expected Output: boolean


Input Type: string
Input Data: This is a string data.
Result: boolean
PASS

Input Type: int
Input Data: 1
Result: boolean
PASS

Input Type: int
Input Data: 0
Result: boolean
PASS

Input Type: float
Input Data: 2
Result: boolean
PASS

Input Type: array
Input Data: array(0) {
}

Result: boolean
PASS

Input Type: boolean
Input Data: 1
Result: boolean
PASS

Input Type: boolean
Input Data: 
Result: boolean
PASS