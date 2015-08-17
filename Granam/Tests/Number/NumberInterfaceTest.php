<?php
namespace Granam\Tests\Number;

class NumberInterfaceTest extends \PHPUnit_Framework_TestCase
{

    /** @test */
    public function inherits_from_scalar_interface()
    {
        $this->assertTrue(is_a('Granam\Number\NumberInterface', 'Granam\Scalar\ScalarInterface', true /* accept class name instead of instance */));
    }
}
