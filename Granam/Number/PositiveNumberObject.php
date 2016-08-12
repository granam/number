<?php
namespace Granam\Number;

use Granam\Number\Tools\ToNumber;

class PositiveNumberObject extends NumberObject implements PositiveNumber
{
    /**
     * @param mixed $value
     * @param bool $strict = false Accepts only explicit values, no null or empty string
     * @param bool $paranoid = false Throws exception if some value is lost on cast because of rounding
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Number\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Number\Tools\Exceptions\PositiveNumberCanNotBeNegative
     */
    public function __construct($value, $strict = true, $paranoid = false)
    {
        parent::__construct(ToNumber::toPositiveNumber($value), $strict, $paranoid);
    }

}