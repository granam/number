<?php
namespace Granam\Tests\Number;

class NegativeNumberTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function I_can_use_it_as_number_interface()
    {
        self::assertTrue(is_a('\Granam\Number\NegativeNumber', '\Granam\Number\NumberInterface', true));
    }
}