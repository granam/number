<?php
namespace Granam\Tests\Number\Tools;

use Granam\Number\Tools\ToNumber;

class ToNumberTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function I_can_use_it_just_with_value_parameter()
    {
        $reflection = new \ReflectionClass(ToNumber::getClass());
        $toNumber = $reflection->getMethod('toNumber');
        self::assertSame(1, $toNumber->getNumberOfRequiredParameters());
    }
}