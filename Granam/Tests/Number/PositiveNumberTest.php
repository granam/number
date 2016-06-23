<?php
namespace Granam\Tests\Number;

use Granam\Number\PositiveNumber;
use Granam\Number\NumberObject;
use Granam\Tests\Tools\TestWithMockery;

class PositiveNumberTest extends TestWithMockery
{
    /**
     * @test
     */
    public function I_can_create_it()
    {
        $twentyFive = new PositiveNumber(25);
        self::assertSame(25, $twentyFive->getValue());
        $twoHundredths = new PositiveNumber(0.02);
        self::assertSame(0.02, $twoHundredths->getValue());
        $zero = new PositiveNumber(-0.00);
        self::assertSame(0.0, $zero->getValue());

        self::assertInstanceOf(NumberObject::class, $twentyFive);
    }

    /**
     * @test
     * @expectedException \Granam\Number\Exceptions\PositiveNumberCanNotBeNegative
     * @expectedExceptionMessageRegExp ~-1~
     */
    public function I_can_not_create_it_negative()
    {
        new PositiveNumber(-1);
    }
}
