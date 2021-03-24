<?php declare(strict_types=1);

namespace Granam\Tests\Number\Tools;

use Granam\Number\NumberInterface;
use Granam\Number\NumberObject;
use Granam\Number\Tools\Exceptions\NegativeNumberCanNotBePositive;
use Granam\Number\Tools\Exceptions\PositiveNumberCanNotBeNegative;
use Granam\Number\Tools\Exceptions\WrongParameterType;
use Granam\Number\Tools\ToNumber;
use Granam\Tests\Number\ICanUseItSameWayAsUsing;

class ToNumberTest extends ICanUseItSameWayAsUsing
{
    /**
     * @test
     * @throws \ReflectionException
     */
    public function I_can_use_it_just_with_value_parameter(): void
    {
        $this->assertUsableWithJustValueParameter(ToNumber::class, 'toNumber');
    }

    /**
     * @test
     * @throws \ReflectionException
     */
    public function I_can_create_it_same_way_as_using_number_object(): void
    {
        parent::I_can_create_it_same_way_as_using();
    }

    /**
     * @test
     */
    public function I_can_not_use_null_by_default(): void
    {
        $this->expectException(WrongParameterType::class);
        ToNumber::toNumber(null);
    }

    /**
     * @test
     */
    public function I_can_not_use_null_if_strict(): void
    {
        $this->expectException(WrongParameterType::class);
        ToNumber::toNumber(null);
    }

    /**
     * @test
     */
    public function I_can_use_null_as_integer_zero_if_not_strict(): void
    {
        self::assertSame(0, ToNumber::toNumber(null, false /* not strict */));
    }

    /**
     * @test
     */
    public function I_can_convert_even_number_object_to_number(): void
    {
        self::assertSame(123, ToNumber::toNumber(new NumberObject(123)));
    }

    /**
     * @test
     */
    public function I_can_require_negative_number(): void
    {
        self::assertSame(-456, ToNumber::toNegativeNumber(-456));

    }

    /**
     * @test
     */
    public function I_can_get_zero_as_negative_number(): void
    {
        self::assertSame(0.0, ToNumber::toNegativeNumber(0.0));
    }

    /**
     * @test
     */
    public function I_can_not_use_positive_number_as_negative(): void
    {
        $this->expectException(NegativeNumberCanNotBePositive::class);
        ToNumber::toNegativeNumber(0.1);
    }

    /**
     * @test
     */
    public function I_can_require_positive_number(): void
    {
        self::assertSame(45.67, ToNumber::toPositiveNumber(45.67));
    }

    /**
     * @test
     */
    public function I_can_get_zero_as_positive_number(): void
    {
        self::assertSame(0.0, ToNumber::toPositiveNumber(0.0));
    }

    /**
     * @test
     */
    public function I_can_not_use_negative_number_as_positive(): void
    {
        $this->expectException(PositiveNumberCanNotBeNegative::class);
        ToNumber::toPositiveNumber(-0.001);
    }

    /**
     * @test
     */
    public function I_can_convert_number_object_even_if_gives_non_number_as_string(): void
    {
        $numberObject = $this->mockery(NumberInterface::class);
        $numberObject->shouldReceive('__toString')
            ->andReturn('123.456 foo');
        $numberObject->shouldReceive('getValue')
            ->andReturn(123.456);
        self::assertSame(123.456, ToNumber::toNumber($numberObject));
    }

    /**
     * @test
     * @dataProvider provideValueOrNull
     * @param $value
     * @param int|float|NumberInterface|null $expectedValue
     */
    public function I_can_get_number_or_null($value, $expectedValue): void
    {
        self::assertSame($expectedValue, ToNumber::toNumberOrNull($value));
        if ($expectedValue === null || $expectedValue <= 0) {
            self::assertSame($expectedValue, ToNumber::toNegativeNumberOrNull($value));
        }
        if ($expectedValue === null || $expectedValue >= 0) {
            self::assertSame($expectedValue, ToNumber::toPositiveNumberOrNull($value));
        }
    }

    public function provideValueOrNull(): array
    {
        return [
            [null, null],
            [1, 1],
            [new NumberObject(-159), -159],
            ['999.888', 999.888],
        ];
    }
}