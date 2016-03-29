<?php
namespace Granam\Tests\Number\Tools;

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
}