<?php
namespace Granam\Number;

use Granam\Number\Tools\ToNumber;
use Granam\Scalar\Scalar;

/**
 * @method float getValue()
 */
class NumberObject extends Scalar implements NumberInterface
{

    /**
     * @var  bool
     */
    protected $paranoid;

    /**
     * @param mixed $value
     * @param bool $paranoid Throws exception if some value is lost on cast because of rounding
     */
    public function __construct($value, $paranoid = false)
    {
        parent::__construct(ToNumber::toNumber($value, (bool)$paranoid));
    }
}
