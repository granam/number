<?php
namespace Granam\Tests\Number\Tools;

use Granam\Number\Tools\ToNumber;
use Granam\Tests\Number\ICanUseItSameWayAsUsing;

class ToNumberTest extends ICanUseItSameWayAsUsing
{
    /**
     * @test
     */
    public function I_can_use_it_just_with_value_parameter()
    {
        $this->assertUsableWithJustValueParameter('\Granam\Number\Tools\ToNumber', 'toNumber');
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
}