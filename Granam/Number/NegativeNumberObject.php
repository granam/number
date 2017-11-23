<?php
declare(strict_types=1); // on PHP 7+ are standard PHP methods strict to types of given parameters

namespace Granam\Number;

use Granam\Number\Tools\ToNumber;

class NegativeNumberObject extends NumberObject implements NegativeNumber
{
    /**
     * @param mixed $value
     * @param bool $strict = false Accepts only explicit values, no null or empty string
     * @param bool $paranoid = false Throws exception if some value is lost on cast because of rounding
     * @throws \Granam\Number\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Number\Tools\Exceptions\NegativeNumberCanNotBePositive
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function __construct($value, bool $strict = true, bool $paranoid = false)
    {
        parent::__construct(ToNumber::toNegativeNumber($value), $strict, $paranoid);
    }

}