# Converter and object wrapper for a number (float or integer) value

[![Build Status](https://travis-ci.org/jaroslavtyc/granam-number.svg?branch=master)](https://travis-ci.org/jaroslavtyc/granam-number)

```php
<?php
use Granam\Number\NumberObject;
use \Granam\Number\Tools\Exceptions\WrongParameterType;

$stringFloatToNumber = new NumberObject('123.456');
var_dump($stringFloatToNumber->getValue()); // double(123.456)
var_dump((string)$stringFloatToNumber); // string(7) "123.456"

$stringIntToNumber = new NumberObject('123');
var_dump($stringIntToNumber->getValue()); // int(123)
var_dump((string)$stringIntToNumber); // string(7) "123"

$nullToNumber = new NumberObject(null);
var_dump($nullToNumber->getValue()); // int(0)
var_dump((string)$nullToNumber); // string(1) "0"

$tooLongDecimalToNumber = new NumberObject($withTooLongDecimal = '123456.999999999999999999999999999999999999');
var_dump($tooLongDecimalToNumber->getValue());// int(123457); because of intval(floatval($value))

try {
  new NumberObject('123.999999999999999999999999999999', true /* paranoid to rounding */);
} catch (WrongParameterType $floatNumberException) {
  // Something get wrong: Some value has been lost on cast. Given string-number '123456.999999999999999999999999999999999999' results into float 123457
  die('Something get wrong: ' . $floatNumberException->getMessage());
}

```
