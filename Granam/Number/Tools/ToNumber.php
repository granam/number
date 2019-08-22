<?php declare(strict_types=1); // on PHP 7+ are standard PHP methods strict to types of given parameters

namespace Granam\Number\Tools;

use Granam\Number\NumberInterface;
use Granam\Scalar\Tools\ToString;
use Granam\Strict\Object\StrictObject;
use Granam\Tools\ValueDescriber;

class ToNumber extends StrictObject
{
    /**
     * @param mixed $value
     * @param bool $strict = true allows only explicit values, empty string or null (remains null)
     * @param bool $paranoid = false raises an exception if some value is lost on cast due to rounding on cast
     * @return float|int|null
     * @throws \Granam\Number\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Number\Tools\Exceptions\ValueLostOnCast
     */
    public static function toNumberOrNull($value, bool $strict = true, bool $paranoid = false)
    {
        if ($value === null) {
            return null;
        }

        return static::toNumber($value, $strict, $paranoid);
    }

    /**
     * @param mixed $value
     * @param bool $strict = true allows only explicit values, not null and empty string
     * @param bool $paranoid = false raises an exception if some value is lost on cast due to rounding on cast
     * @return float|int
     * @throws \Granam\Number\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Number\Tools\Exceptions\ValueLostOnCast
     */
    public static function toNumber($value, bool $strict = true, bool $paranoid = false)
    {
        if (\is_float($value)) {
            return $value;
        }
        if (\is_int($value)) {
            return $value;
        }
        if (\is_bool($value)) {
            // true = 1; false = 0;
            return (int)$value;
        }
        if ($value instanceof NumberInterface) {
            return $value->getValue();
        }

        try {
            $stringValue = \trim(ToString::toString($value, $strict));
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

    /**
     * @param float $floatValue
     * @param string $stringValue
     * @throws \Granam\Number\Tools\Exceptions\ValueLostOnCast
     */
    private static function checkIfNoValueHasBeenLostByCast(float $floatValue, string $stringValue): void
    {
        $numericPart = '0';
        if (\preg_match('~^(?:\s*0*)(?<numericPart>\d+(\.([1-9]+|0+(?=[1-9]+))+)*)~', $stringValue, $numericParts) > 0) {
            $numericPart = $numericParts['numericPart'];
        }

        if ((string)$floatValue !== $numericPart) { // some value has been lost
            throw new Exceptions\ValueLostOnCast(
                'Some value has been lost on cast. Given string-number '
                . \var_export($numericPart, true) . ' results into float ' . \var_export($floatValue, true)
            );
        }
    }

    /**
     * @param mixed $value
     * @param bool $strict = true allows only explicit values, empty string or null (remains null)
     * @param bool $paranoid = false raises an exception if some value is lost on cast due to rounding on cast
     * @return float|int|null
     * @throws \Granam\Number\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Number\Tools\Exceptions\ValueLostOnCast
     */
    public static function toPositiveNumberOrNull($value, bool $strict = true, bool $paranoid = false)
    {
        if ($value === null) {
            return null;
        }

        return static::toPositiveNumber($value, $strict, $paranoid);
    }

    /**
     * @param $value
     * @param bool $strict = true allows only explicit values, not null and empty string
     * @param bool $paranoid = false raises an exception if some value is lost on cast due to rounding on cast
     * @return float|int
     * @throws \Granam\Number\Tools\Exceptions\ValueLostOnCast
     * @throws \Granam\Number\Tools\Exceptions\PositiveNumberCanNotBeNegative
     * @throws \Granam\Number\Tools\Exceptions\WrongParameterType
     */
    public static function toPositiveNumber($value, bool $strict = true, bool $paranoid = false)
    {
        $positive = static::toNumber($value, $strict, $paranoid);
        if ($positive < 0) {
            throw new Exceptions\PositiveNumberCanNotBeNegative(
                'Expected positive number, got ' . ValueDescriber::describe($value)
            );
        }

        return $positive;
    }

    /**
     * @param $value
     * @param bool $strict = true allows only explicit values, not null and empty string
     * @param bool $paranoid = false raises an exception if some value is lost on cast due to rounding on cast
     * @return float|int|null
     * @throws \Granam\Number\Tools\Exceptions\ValueLostOnCast
     * @throws \Granam\Number\Tools\Exceptions\NegativeNumberCanNotBePositive
     * @throws \Granam\Number\Tools\Exceptions\WrongParameterType
     */
    public static function toNegativeNumberOrNull($value, bool $strict = true, bool $paranoid = false)
    {
        if ($value === null) {
            return null;
        }

        return static::toNegativeNumber($value, $strict, $paranoid);
    }

    /**
     * @param $value
     * @param bool $strict = true allows only explicit values, not null and empty string
     * @param bool $paranoid = false raises an exception if some value is lost on cast due to rounding on cast
     * @return float|int
     * @throws \Granam\Number\Tools\Exceptions\ValueLostOnCast
     * @throws \Granam\Number\Tools\Exceptions\NegativeNumberCanNotBePositive
     * @throws \Granam\Number\Tools\Exceptions\WrongParameterType
     */
    public static function toNegativeNumber($value, bool $strict = true, bool $paranoid = false)
    {
        $positive = static::toNumber($value, $strict, $paranoid);
        if ($positive > 0) {
            throw new Exceptions\NegativeNumberCanNotBePositive(
                'Expected positive number, got ' . ValueDescriber::describe($value)
            );
        }

        return $positive;
    }
}