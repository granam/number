<?php
namespace Granam\Number;

use Granam\Number\Tools\ToNumber;
use Granam\Scalar\Scalar;

class NumberObject extends Scalar implements NumberInterface
{
    /**
     * @param mixed $value
     * @param bool $strict = false Accepts only explicit values, no null or empty string
     * @param bool $paranoid = false Throws exception if some value is lost on cast because of rounding
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function __construct($value, $strict = true, $paranoid = false)
    {
        parent::__construct(ToNumber::toNumber($value, (bool)$strict, (bool)$paranoid));
    }
}
