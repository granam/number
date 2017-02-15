<?php
namespace Granam\Number;

use Granam\Scalar\ScalarInterface;

interface NumberInterface extends ScalarInterface
{
    /**
     * @return int|float
     */
    public function getValue();
}