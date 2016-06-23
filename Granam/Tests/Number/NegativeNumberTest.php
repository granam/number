<?php
namespace Granam\Tests\Number;

use Granam\Number\NegativeNumber;
use Granam\Number\NumberObject;
use Granam\Tests\Tools\TestWithMockery;

class NegativeNumberTest extends TestWithMockery
{
    /**
     * @test
     */
    public function I_can_create_it()
    {
        $minusOne = new NegativeNumber(-1);
        self::assertSame(-1, $minusOne->getValue());
        $floatMinusOne = new NegativeNumber(-1.0);
        self::assertSame(-1.0, $floatMinusOne->getValue());
        $zero = new NegativeNumber(0.00);
        self::assertSame(0.0, $zero->getValue());

        self::assertInstanceOf(NumberObject::class, $minusOne);
    }

    /**
     * @test
     * @expectedException \Granam\Number\Exceptions\NegativeNumberCanNotBePositive
     * @expectedExceptionMessageRegExp ~\s0[.]01~
     */
    public function I_can_not_create_it_positive()
    {
        new NegativeNumber(0.01);
    }
}
