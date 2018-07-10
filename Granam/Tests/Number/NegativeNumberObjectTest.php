<?php
declare(strict_types = 1);

namespace Granam\Tests\Number;

use Granam\Number\NegativeNumber;
use Granam\Number\NegativeNumberObject;
use Granam\Number\NumberObject;
use PHPUnit\Framework\TestCase;

class NegativeNumberObjectTest extends TestCase
{
    /**
     * @test
     */
    public function I_can_create_it(): void
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
     * @expectedException \Granam\Number\Tools\Exceptions\NegativeNumberCanNotBePositive
     * @expectedExceptionMessageRegExp ~\s0[.]01~
     */
    public function I_can_not_create_it_positive(): void
    {
        new NegativeNumberObject(0.01);
    }
}