<?php
namespace Granam\Tests\Number;

use Granam\Number\NumberInterface;
use Granam\Number\PositiveNumber;

class PositiveNumberTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function I_can_use_it_as_number_interface()
    {
        self::assertTrue(is_a(PositiveNumber::class, NumberInterface::class, true));
    }
}