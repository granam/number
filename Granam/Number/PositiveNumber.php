<?php
namespace Granam\Number;

use Granam\Tools\ValueDescriber;

class PositiveNumber extends NumberObject
{
    /**
     * @param mixed $value
     * @param bool $strict = false Accepts only explicit values, no null or empty string
     * @param bool $paranoid = false Throws exception if some value is lost on cast because of rounding
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Number\Exceptions\PositiveNumberCanNotBeNegative
     */
    public function __construct($value, $strict = true, $paranoid = false)
    {
        parent::__construct($value, $strict, $paranoid);
        if ($this->getValue() < 0) {
            throw new Exceptions\PositiveNumberCanNotBeNegative(
                'Required positive number or zero, got ' . ValueDescriber::describe($value)
            );
        }
    }

}