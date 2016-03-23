<?php
namespace Granam\Number\Tools;

use Granam\Scalar\Tools\ToString;
use Granam\Strict\Object\StrictObject;
use Granam\Tools\ValueDescriber;

class ToNumber extends StrictObject
{
    /**
     * @param $value
     * @param bool $strict = true allows only explicit values, not null and empty string
     * @param bool $paranoid = false raises an exception if some value is lost on cast due to rounding on cast
     *
     * @return float|int
     */
    public static function toNumber($value, $strict = true, $paranoid = false)
    {
        if (is_float($value)) {
            return $value;
        }
        if (is_int($value)) {
            return $value;
        }
        if (is_bool($value)) {
            // true = 1; false = 0;
            return (int)$value;
        }

        try {
            $stringValue = ToString::toString($value);
        } catch (\Granam\Scalar\Tools\Exceptions\WrongParameterType $exception) {
            throw new Exceptions\WrongParameterType($exception->getMessage(), $exception->getCode(), $exception);
        }

        if ($strict && !is_numeric($stringValue)) { // no number at all (casted null, empty string, non-digits...)
            throw new Exceptions\WrongParameterType(
                'Only numbers and booleans are allowed in strict mode, got ' . ValueDescriber::describe($value)
                . ' expressed as string ' . ValueDescriber::describe($stringValue)
            );
        }

        $floatValue = (float)$stringValue; // note: '' = 0.0
        if ($paranoid) {
            self::checkIfNoValueHasBeenLostByCast($floatValue, $stringValue);
        }

        $intValue = (int)$floatValue;
        if ((float)$intValue === $floatValue) {
            return $intValue;
        }

        return $floatValue;
    }

    private static function checkIfNoValueHasBeenLostByCast($floatValue, $stringValue)
    {
        $numericPart = '0';
        if (preg_match('~^(?:\s*0*)(?<numericPart>\d+(\.([1-9]+|0+(?=[1-9]+))+)*)~', $stringValue, $numericParts) > 0) {
            $numericPart = $numericParts['numericPart'];
        }

        if ("$floatValue" !== $numericPart) { // some value has been lost
            throw new Exceptions\ValueLostOnCast(
                'Some value has been lost on cast. Given string-number ' . var_export($numericPart, true) . ' results into float ' . var_export($floatValue, true)
            );
        }
    }
}
