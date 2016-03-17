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
        self::assertNotNull($numberObject);
        self::assertInstanceOf('Granam\Number\NumberInterface', $numberObject);
    }

    /**
     * @test
     */
    public function I_can_get_given_value()
    {
        $numberObject = new NumberObject($floatValue = 123.456);
        self::assertSame($floatValue, $numberObject->getValue());
    }

    /**
     * @test
     */
    public function I_can_use_it_as_a_string()
    {
        $numberObject = new NumberObject($floatValue = 123.456);
        self::assertSame("$floatValue", "$numberObject");
    }

    /**
     * @test
     */
    public function I_can_use_integer()
    {
        $numberObject = new NumberObject($integer = 123);
        self::assertSame($integer, $numberObject->getValue());
        $numberObject = new NumberObject($stringInteger = '456');
        self::assertSame((int)$stringInteger, $numberObject->getValue());
        self::assertSame("$stringInteger", "$numberObject");
    }

    /**
     * @test
     */
    public function I_can_use_false_to_get_integer_zero()
    {
        $numberObject = new NumberObject(false);
        self::assertSame(0, $numberObject->getValue());
        self::assertSame((int)false, $numberObject->getValue());
    }

    /**
     * @test
     */
    public function I_can_use_true_to_get_integer_one()
    {
        $numberObject = new NumberObject(true);
        self::assertSame(1, $numberObject->getValue());
        self::assertSame((int)true, $numberObject->getValue());
    }

    /**
     * @test
     */
    public function I_can_use_null_as_integer_zero()
    {
        $numberObject = new NumberObject(null);
        self::assertSame(0, $numberObject->getValue());
        self::assertSame((int)null, $numberObject->getValue());
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
        self::assertSame($floatValue, $floatNumberObject->getValue());
        $integerNumberObject = new NumberObject(new TestWithToString($integerValue = 789));
        self::assertSame($integerValue, $integerNumberObject->getValue());
        $stringAsFloatNumberObject = new NumberObject(new TestWithToString($stringAsFloat = '987.654'));
        self::assertSame((float)$stringAsFloat, $stringAsFloatNumberObject->getValue());
        $stringAsIntegerNumberObject = new NumberObject(new TestWithToString($stringAsInteger = '7890'));
        self::assertSame((int)$stringAsInteger, $stringAsIntegerNumberObject->getValue());
    }

    /**
     * @test
     */
    public function I_get_integer_zero_for_to_string_object_without_number()
    {
        $float = new NumberObject(new TestWithToString($string = 'non-float'));
        self::assertSame(0, $float->getValue());
        self::assertSame((int)$string, $float->getValue());
    }

    /**
     * @test
     */
    public function I_get_number_without_wrapping_trash()
    {
        $withWrappingZeroes = new NumberObject($zeroWrappedNumber = '0000123456.789000');
        self::assertSame(123456.789, $withWrappingZeroes->getValue());
        self::assertSame((float)$zeroWrappedNumber, $withWrappingZeroes->getValue());
        $integerLike = new NumberObject($integerLikeNumber = '0000123456.0000');
        self::assertSame(123456, $integerLike->getValue());
        self::assertSame((int)$integerLikeNumber, $integerLike->getValue());
        $trashAround = new NumberObject($trashWrappedNumber = '   123456.0051500  foo bar 12565.04181 ');
        self::assertSame(123456.00515, $trashAround->getValue());
        self::assertSame((float)$trashWrappedNumber, $trashAround->getValue());
    }

    /**
     * @test
     */
    public function I_get_silently_rounded_number_by_default()
    {
        $float = new NumberObject($withTooLongDecimal = '123456.999999999999999999999999999999999999');
        self::assertSame(123457, $float->getValue());
        self::assertSame((int)(float)$withTooLongDecimal, $float->getValue());
        $float = new NumberObject($withTooLongInteger = '222222222222222222222222222222222222222222.123');
        self::assertSame(2.2222222222222224E+41, $float->getValue());
        self::assertSame((float)$withTooLongInteger, $float->getValue());
    }

    /**
     * @test
     * @expectedException \Granam\Number\Tools\Exceptions\ValueLostOnCast
     */
    public function I_can_force_exception_on_rounding()
    {
        $nothingIsLost = new NumberObject($value = '123456.9999999', true /* paranoid */);
        self::assertSame((float)$value, $nothingIsLost->getValue());
        try {
            new NumberObject('123456.999999999999999999999999999999999999', true /* paranoid */);
            self::fail('Paranoid test failed');
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
