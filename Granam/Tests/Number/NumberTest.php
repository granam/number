<?php
namespace Granam\Tests\Number;

use Granam\Number\NumberObject;

class NumberTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function I_can_create_number_object()
    {
        $numberObject = new NumberObject(123.456);
        $this->assertNotNull($numberObject);
        $this->assertInstanceOf('Granam\Number\NumberInterface', $numberObject);
    }

    /**
     * @test
     */
    public function I_can_get_given_value()
    {
        $numberObject = new NumberObject($floatValue = 123.456);
        $this->assertSame($floatValue, $numberObject->getValue());
    }

    /**
     * @test
     */
    public function I_can_use_it_as_a_string()
    {
        $numberObject = new NumberObject($floatValue = 123.456);
        $this->assertSame("$floatValue", "$numberObject");
    }

    /**
     * @test
     */
    public function I_can_use_integer()
    {
        $numberObject = new NumberObject($integer = 123);
        $this->assertSame($integer, $numberObject->getValue());
        $numberObject = new NumberObject($stringInteger = '456');
        $this->assertSame(intval($stringInteger), $numberObject->getValue());
        $this->assertSame("$stringInteger", "$numberObject");
    }

    /**
     * @test
     */
    public function I_can_use_false_to_get_integer_zero()
    {
        $numberObject = new NumberObject(false);
        $this->assertSame(0, $numberObject->getValue());
        $this->assertSame(intval(false), $numberObject->getValue());
    }

    /**
     * @test
     */
    public function I_can_use_true_to_get_integer_one()
    {
        $numberObject = new NumberObject(true);
        $this->assertSame(1, $numberObject->getValue());
        $this->assertSame(intval(true), $numberObject->getValue());
    }

    /**
     * @test
     */
    public function I_can_use_null_as_integer_zero()
    {
        $numberObject = new NumberObject(null);
        $this->assertSame(0, $numberObject->getValue());
        $this->assertSame(intval(null), $numberObject->getValue());
    }

    /**
     * @test
     * @expectedException \Granam\Number\Exceptions\WrongParameterType
     */
    public function I_cannot_use_array()
    {
        new NumberObject([]);
    }

    /**
     * @test
     * @expectedException \Granam\Number\Exceptions\WrongParameterType
     */
    public function I_cannot_use_resource()
    {
        new NumberObject(tmpfile());
    }

    /**
     * @test
     * @expectedException \Granam\Number\Exceptions\WrongParameterType
     */
    public function I_cannot_use_object_without_to_string_magic()
    {
        new NumberObject(new \stdClass());
    }

    /**
     * @test
     */
    public function I_can_use_object_with_to_string()
    {
        $floatNumberObject = new NumberObject(new TestWithToString($floatValue = 123.456));
        $this->assertSame($floatValue, $floatNumberObject->getValue());
        $integerNumberObject = new NumberObject(new TestWithToString($integerValue = 789));
        $this->assertSame($integerValue, $integerNumberObject->getValue());
        $stringAsFloatNumberObject = new NumberObject(new TestWithToString($stringAsFloat = '987.654'));
        $this->assertSame(floatval($stringAsFloat), $stringAsFloatNumberObject->getValue());
        $stringAsIntegerNumberObject = new NumberObject(new TestWithToString($stringAsInteger = '7890'));
        $this->assertSame(intval($stringAsInteger), $stringAsIntegerNumberObject->getValue());
    }

    /**
     * @test
     */
    public function I_get_integer_zero_for_to_string_object_without_number()
    {
        $float = new NumberObject(new TestWithToString($string = 'non-float'));
        $this->assertSame(0, $float->getValue());
        $this->assertSame(intval($string), $float->getValue());
    }

    /**
     * @test
     */
    public function I_get_number_without_wrapping_trash()
    {
        $withWrappingZeroes = new NumberObject($zeroWrappedNumber = '0000123456.789000');
        $this->assertSame(123456.789, $withWrappingZeroes->getValue());
        $this->assertSame(floatval($zeroWrappedNumber), $withWrappingZeroes->getValue());
        $integerLike = new NumberObject($integerLikeNumber = '0000123456.0000');
        $this->assertSame(123456, $integerLike->getValue());
        $this->assertSame(intval($integerLikeNumber), $integerLike->getValue());
        $trashAround = new NumberObject($trashWrappedNumber = '   123456.0051500  foo bar 12565.04181 ');
        $this->assertSame(123456.00515, $trashAround->getValue());
        $this->assertSame(floatval($trashWrappedNumber), $trashAround->getValue());
    }

    /**
     * @test
     */
    public function I_get_silently_rounded_number_by_default()
    {
        $float = new NumberObject($withTooLongDecimal = '123456.999999999999999999999999999999999999');
        $this->assertSame(123457, $float->getValue());
        $this->assertSame(intval(floatval($withTooLongDecimal)), $float->getValue());
        $float = new NumberObject($withTooLongInteger = '222222222222222222222222222222222222222222.123');
        $this->assertSame(2.2222222222222224E+41, $float->getValue());
        $this->assertSame(floatval($withTooLongInteger), $float->getValue());
    }

    /**
     * @test
     * @expectedException \Granam\Number\Tools\Exceptions\ValueLostOnCast
     */
    public function I_can_force_exception_on_rounding()
    {
        $nothingIsLost = new NumberObject($value = '123456.9999999', true /* paranoid */);
        $this->assertSame(floatval($value), $nothingIsLost->getValue());
        try {
            new NumberObject('123456.999999999999999999999999999999999999', true /* paranoid */);
            $this->fail('Paranoid test failed');
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

}

/** inner */
class TestWithToString
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function __toString()
    {
        return (string)$this->value;
    }
}
