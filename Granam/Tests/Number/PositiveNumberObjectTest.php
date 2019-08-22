<?php declare(strict_types=1);

namespace Granam\Tests\Number;

use Granam\Number\PositiveNumberObject;
use Granam\Number\NumberObject;
use Granam\Number\PositiveNumber;
use Granam\Number\Tools\Exceptions\PositiveNumberCanNotBeNegative;
use PHPUnit\Framework\TestCase;

class PositiveNumberObjectTest extends TestCase
{
    /**
     * @test
     */
    public function I_can_create_it(): void
    {
        $twentyFive = new PositiveNumberObject(25);
        self::assertSame(25, $twentyFive->getValue());
        self::assertInstanceOf(NumberObject::class, $twentyFive);
        self::assertInstanceOf(PositiveNumber::class, $twentyFive);

        $twoHundredths = new PositiveNumberObject(0.02);
        self::assertSame(0.02, $twoHundredths->getValue());
        self::assertInstanceOf(NumberObject::class, $twoHundredths);
        self::assertInstanceOf(PositiveNumber::class, $twoHundredths);

        $zero = new PositiveNumberObject(-0.00);
        self::assertSame(0.0, $zero->getValue());
        self::assertInstanceOf(NumberObject::class, $zero);
        self::assertInstanceOf(PositiveNumber::class, $zero);
    }

    /**
     * @test
     */
    public function I_can_not_create_it_negative(): void
    {
        $this->expectException(PositiveNumberCanNotBeNegative::class);
        $this->expectExceptionMessageRegExp('~-1~');
        new PositiveNumberObject(-1);
    }
}