<?php
namespace Granam\Number;

use Granam\Tools\ValueDescriber;

class NegativeNumberObject extends NumberObject implements NegativeNumber
{
    /**
     * @param mixed $value
     * @param bool $strict = false Accepts only explicit values, no null or empty string
     * @param bool $paranoid = false Throws exception if some value is lost on cast because of rounding
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Number\Exceptions\NegativeNumberCanNotBePositive
     */
    public function __construct($value, $strict = true, $paranoid = false)
    {
        parent::__construct($value, $strict, $paranoid);
        if ($this->getValue() > 0) {
            throw new Exceptions\NegativeNumberCanNotBePositive(
                'Required negative number or zero, got ' . ValueDescriber::describe($value)
            );
        }
    }

}