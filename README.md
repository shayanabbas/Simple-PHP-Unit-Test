# Simple-PHP-Unit-Test
Simple-PHP-Unit-Test library generate a simple unit test report after testing your methods with different types of variables and inputs.

## Requirement
PHP v7

## How to use?
Include and initialize the library on your file.
```php
include_once('classes/Test.class.php');
$test = new Test();
```

Include and initialize your class to test it's method.
As for a reference I have added a small Data class in [classes/Data.class.php](https://github.com/shayanabbas/Simple-PHP-Unit-Test/blob/master/classes/Data.class.php)
So we are going to use it for reference, you can also check/run [tests.php](https://github.com/shayanabbas/Simple-PHP-Unit-Test/blob/master/tests.php) file

```php
include_once('classes/Data.class.php');
$data = new Data();
```

Now were going to test $data->validateFileEncoding() method
Check the following for parameter details
```php
* @param class $class class of which method to be tested
* @param string $method name of method of the class
* @param string $expectedOutput output that is expected 
* @param int $numberOfParams number of params in method. Default: 1
* @param array $additionalData additional data to test. (optional)
```
Now we will test our method.
```php
$test->result( $data, 'validateFileEncoding', 'boolean', '1' );
```
Once Run it will show results like following and also check [unit_test_results.html](https://github.com/shayanabbas/Simple-PHP-Unit-Test/blob/master/unit_test_results.html)
```html
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
```

## Credits
[@shayanabbas](https://github.com/shayanabbas/)
### Buy me a coffee
```
BTC 36HyrBuZU4ZfaP7fo58abm7ryp2qtmRoC2
ETH 0xb30d4977DC307617cFD1F4d55cE969316d7b44E2
XRP rN3871uxDiGt3hfaPXe2x31EbKAzHY5Bqj
ETC 0x0B600A27ebD06A3820acfEC2E277E61b9297850b
LTC MUAy1xBxKYap4y8id58L4g8U89R6jGizNN
BCH 1PogvRYk9vNwghSGzhuANRFYM2ppqLPqG7
NEO AUQ1vfwpycjXTf5gq3F4fKinRL6xfhB1em
```