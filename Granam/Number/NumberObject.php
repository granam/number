<?php
namespace Granam\Number;

use Granam\Number\Tools\ToNumber;
use Granam\Scalar\Scalar;

class NumberObject extends Scalar implements NumberInterface
{
    /**
     * @var bool
     */
    protected $strict;
    /**
     * @var bool
     */
    protected $paranoid;

    /**
     * @param mixed $value
     * @param bool $strict = false Accepts only explicit values, no null or empty string
     * @param bool $paranoid = false Throws exception if some value is lost on cast because of rounding
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function __construct($value, $strict = true, $paranoid = false)
    {
        $this->strict = (bool)$strict;
        $this->paranoid = (bool)$paranoid;
        parent::__construct(ToNumber::toNumber($value, $this->strict, $this->paranoid));
    }

    /**
     * @param int|float|NumberInterface $value
     * @return NumberInterface
     * @throws \Granam\Number\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function add($value)
    {
        return new static(
            $this->getValue()
            + ToNumber::toNumber($value, $this->strict, $this->paranoid),
            $this->strict,
            $this->paranoid
        );
    }

    /**
     * @param int|float|NumberInterface $value
     * @return NumberInterface
     * @throws \Granam\Number\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function sub($value)
    {
        return new static(
            $this->getValue()
            - ToNumber::toNumber($value, $this->strict, $this->paranoid),
            $this->strict,
            $this->paranoid
        );
    }

}