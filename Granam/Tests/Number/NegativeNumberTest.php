<?php
namespace Granam\Tests\Number;

use Granam\Number\NegativeNumber;
use Granam\Number\NumberInterface;

class NegativeNumberTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function I_can_use_it_as_number_interface()
    {
        self::assertTrue(is_a(NegativeNumber::class, NumberInterface::class, true));
    }
}