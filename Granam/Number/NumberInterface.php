<?php
namespace Granam\Number;

use Granam\Scalar\ScalarInterface;

interface NumberInterface extends ScalarInterface
{
    /**
     * @return int|float
     */
    public function getValue();

    /**
     * @param int|float|NumberInterface $value
     * @return NumberInterface
     */
    public function add($value);

    /**
     * @param int|float|NumberInterface $value
     * @return NumberInterface
     */
    public function sub($value);
}
