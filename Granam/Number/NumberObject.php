<?php
namespace Granam\Number;

use Granam\Number\Tools\ToNumber;
use Granam\Scalar\Scalar;

class NumberObject extends Scalar implements NumberInterface
{

    public static function createTolerant($value)
    {
        return new static($value, false /* not strict */, false /* not paranoid */);
    }

    public static function createStrictAndParanoid($value)
    {
        return new static($value, true /* strict */, true /* paranoid*/);
    }

    public static function createParanoid($value)
    {
        return new static($value, false /* not strict */, true /* paranoid */);
    }

    /**
     * @param mixed $value
     * @param bool $strict = false Accepts only explicit values, no null or empty string
     * @param bool $paranoid = false Throws exception if some value is lost on cast because of rounding
     */
    public function __construct($value, $strict = true, $paranoid = false)
    {
        parent::__construct(ToNumber::toNumber($value, (bool)$strict, (bool)$paranoid));
    }
}
