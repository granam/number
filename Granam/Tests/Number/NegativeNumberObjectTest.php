<?php
namespace Granam\Tests\Number;

use Granam\Number\NegativeNumber;
use Granam\Number\NegativeNumberObject;
use Granam\Number\NumberObject;

class NegativeNumberObjectTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function I_can_create_it()
    {
        $minusOne = new NegativeNumberObject(-1);
        self::assertSame(-1, $minusOne->getValue());
        self::assertInstanceOf(NumberObject::class, $minusOne);
        self::assertInstanceOf(NegativeNumber::class, $minusOne);

        $floatMinusOne = new NegativeNumberObject(-1.0);
        self::assertSame(-1.0, $floatMinusOne->getValue());
        self::assertInstanceOf(NumberObject::class, $floatMinusOne);
        self::assertInstanceOf(NegativeNumber::class, $floatMinusOne);

        $zero = new NegativeNumberObject(0.00);
        self::assertSame(0.0, $zero->getValue());
        self::assertInstanceOf(NumberObject::class, $zero);
        self::assertInstanceOf(NegativeNumber::class, $zero);
    }

    /**
     * @test
     * @expectedException \Granam\Number\Exceptions\NegativeNumberCanNotBePositive
     * @expectedExceptionMessageRegExp ~\s0[.]01~
     */
    public function I_can_not_create_it_positive()
    {
        new NegativeNumberObject(0.01);
    }
}
