<?php
namespace Granam\Tests\Number\Tools;

use Granam\Number\NumberObject;
use Granam\Number\Tools\ToNumber;
use Granam\Tests\Number\ICanUseItSameWayAsUsing;

class ToNumberTest extends ICanUseItSameWayAsUsing
{
    /**
     * @test
     */
    public function I_can_use_it_just_with_value_parameter()
    {
        $this->assertUsableWithJustValueParameter(ToNumber::class, 'toNumber');
    }

    /**
     * @test
     */
    public function I_can_create_it_same_way_as_using_number_object()
    {
        parent::I_can_create_it_same_way_as_using();
    }

    /**
     * @test
     * @expectedException \Granam\Number\Tools\Exceptions\WrongParameterType
     */
    public function I_can_not_use_null_by_default()
    {
        ToNumber::toNumber(null);
    }

    /**
     * @test
     * @expectedException \Granam\Number\Tools\Exceptions\WrongParameterType
     */
    public function I_can_not_use_null_if_strict()
    {
        ToNumber::toNumber(null);
    }

    /**
     * @test
     */
    public function I_can_use_null_as_integer_zero_if_not_strict()
    {
        self::assertSame(0, ToNumber::toNumber(null, false /* not strict */));
    }

    /**
     * @test
     */
    public function I_can_convert_even_number_object_to_number()
    {
        self::assertSame(123, ToNumber::toNumber(new NumberObject(123)));
    }

    /**
     * @test
     */
    public function I_can_require_negative_number()
    {
        self::assertSame(-456, ToNumber::toNegativeNumber(-456));

    }

    /**
     * @test
     */
    public function I_can_get_zero_as_negative_number()
    {
        self::assertSame(0.0, ToNumber::toNegativeNumber(0.0));
    }

    /**
     * @test
     * @expectedException \Granam\Number\Tools\Exceptions\NegativeNumberCanNotBePositive
     */
    public function I_can_not_use_positive_number_as_negative()
    {
        ToNumber::toNegativeNumber(0.1);
    }

    /**
     * @test
     */
    public function I_can_require_positive_number()
    {
        self::assertSame(45.67, ToNumber::toPositiveNumber(45.67));
    }

    /**
     * @test
     */
    public function I_can_get_zero_as_positive_number()
    {
        self::assertSame(0.0, ToNumber::toPositiveNumber(0.0));
    }

    /**
     * @test
     * @expectedException \Granam\Number\Tools\Exceptions\PositiveNumberCanNotBeNegative
     */
    public function I_can_not_use_negative_number_as_positive()
    {
        ToNumber::toPositiveNumber(-0.001);
    }
}