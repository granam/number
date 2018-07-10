<?php
declare(strict_types=1);

namespace Granam\Tests\Number;

use Granam\Number\NumberObject;
use Granam\Number\NumberInterface;

class NumberObjectTest extends ICanUseItSameWayAsUsing
{
    /**
     * @test
     * @throws \ReflectionException
     */
    public function I_can_use_it_just_with_value_parameter(): void
    {
        $this->assertUsableWithJustValueParameter(NumberObject::class, '__construct');
    }

    /**
     * @test
     * @throws \ReflectionException
     */
    public function I_can_create_it_same_way_as_using_to_number(): void
    {
        parent::I_can_create_it_same_way_as_using();
    }

    /**
     * @test
     * @dataProvider provideStrictnessAndParanoia
     * @param bool $strict
     * @param bool $paranoid
     */
    public function I_can_use_it(bool $strict, bool $paranoid): void
    {
        $numberObject = new NumberObject($value = 123.456, $strict, $paranoid);
        self::assertNotNull($numberObject);
        self::assertInstanceOf(NumberInterface::class, $numberObject);
        self::assertSame((string)$value, (string)$numberObject);
    }

    public function provideStrictnessAndParanoia(): array
    {
        return [
            [false, false],
            [false, true],
            [true, false],
            [true, true],
        ];
    }

    /**
     * @test
     * @dataProvider provideStrictnessAndParanoia
     * @param bool $strict
     * @param bool $paranoid
     */
    public function I_can_get_given_value(bool $strict, bool $paranoid): void
    {
        $numberObject = new NumberObject($value = 123.456, $strict, $paranoid);
        self::assertSame($value, $numberObject->getValue());
    }

    /**
     * @test
     * @dataProvider provideStrictnessAndParanoia
     * @param bool $strict
     * @param bool $paranoid
     */
    public function I_can_use_integer(bool $strict, bool $paranoid): void
    {
        $withInteger = new NumberObject($integer = 123, $strict, $paranoid);
        self::assertSame($integer, $withInteger->getValue());
        $withStringInteger = new NumberObject($stringInteger = '456', $strict, $paranoid);
        self::assertSame((int)$stringInteger, $withStringInteger->getValue());
        self::assertSame($stringInteger, (string)$withStringInteger);
    }

    /**
     * @test
     * @dataProvider provideStrictnessAndParanoia
     * @param bool $strict
     * @param bool $paranoid
     */
    public function I_can_use_false_to_get_integer_zero(bool $strict, bool $paranoid): void
    {
        $numberObject = new NumberObject($value = false, $strict, $paranoid);
        self::assertSame(0, $numberObject->getValue());
        self::assertSame((int)false, $numberObject->getValue());
    }

    /**
     * @test
     * @dataProvider provideStrictnessAndParanoia
     * @param bool $strict
     * @param bool $paranoid
     */
    public function I_can_use_true_to_get_integer_one(bool $strict, bool $paranoid): void
    {
        $numberObject = new NumberObject($value = true, $strict, $paranoid);
        self::assertSame(1, $numberObject->getValue());
        self::assertSame((int)true, $numberObject->getValue());
    }

    /**
     * @test
     * @expectedException \Granam\Number\Tools\Exceptions\WrongParameterType
     * @expectedExceptionMessageRegExp ~got NULL~
     */
    public function I_can_not_use_null_by_default(): void
    {
        new NumberObject(null);
    }

    /**
     * @test
     * @dataProvider provideParanoia
     * @param bool $paranoid
     */
    public function I_can_use_null_as_integer_zero_if_not_strict(bool $paranoid): void
    {
        $numberObject = new NumberObject($value = null, false /* not strict */, $paranoid);
        self::assertSame(0, $numberObject->getValue());
        self::assertSame((int)null, $numberObject->getValue());
    }

    public function provideParanoia(): array
    {
        return [
            [true],
            [false],
        ];
    }

    /**
     * @test
     * @expectedException \Granam\Number\Tools\Exceptions\WrongParameterType
     * @dataProvider provideStrictnessAndParanoia
     * @param bool $strict
     * @param bool $paranoid
     */
    public function I_cannot_use_array(bool $strict, bool $paranoid): void
    {
        new NumberObject([], $strict, $paranoid);
    }

    /**
     * @test
     * @expectedException \Granam\Number\Tools\Exceptions\WrongParameterType
     * @dataProvider provideStrictnessAndParanoia
     * @param bool $strict
     * @param bool $paranoid
     */
    public function I_cannot_use_resource(bool $strict, bool $paranoid): void
    {
        new NumberObject(tmpfile(), $strict, $paranoid);
    }

    /**
     * @test
     * @expectedException \Granam\Number\Tools\Exceptions\WrongParameterType
     * @dataProvider provideStrictnessAndParanoia
     * @param bool $strict
     * @param bool $paranoid
     */
    public function I_cannot_use_object_without_to_string_magic(bool $strict, bool $paranoid): void
    {
        new NumberObject(new \stdClass(), $strict, $paranoid);
    }

    /**
     * @test
     * @dataProvider provideStrictnessAndParanoia
     * @param bool $strict
     * @param bool $paranoid
     */
    public function I_can_use_object_with_to_string(bool $strict, bool $paranoid): void
    {
        $floatNumberObject = new NumberObject(new TestWithToString($floatValue = 123.456), $strict, $paranoid);
        self::assertSame($floatValue, $floatNumberObject->getValue());
        $integerNumberObject = new NumberObject(new TestWithToString($integerValue = 789), $strict, $paranoid);
        self::assertSame($integerValue, $integerNumberObject->getValue());
        $stringAsFloatNumberObject = new NumberObject(new TestWithToString($stringFloat = '987.654'), $strict, $paranoid);
        self::assertSame((float)$stringFloat, $stringAsFloatNumberObject->getValue());
        $stringAsIntegerNumberObject = new NumberObject(new TestWithToString($stringInteger = '7890'), $strict, $paranoid);
        self::assertSame((int)$stringInteger, $stringAsIntegerNumberObject->getValue());
    }

    /**
     * @test
     * @expectedException \Granam\Number\Tools\Exceptions\WrongParameterType
     * @dataProvider provideNonNumericNonBoolean
     * @param $value
     */
    public function I_can_not_use_non_numeric_non_boolean_by_default($value): void
    {
        new NumberObject($value);
    }

    public function provideNonNumericNonBoolean(): array
    {
        return [
            [null],
            [''],
            ["  \n\t  \r"],
            ['one'],
            ['one 2'],
        ];
    }

    /**
     * @test
     * @dataProvider provideParanoia
     * @param bool $paranoid
     */
    public function I_got_zero_from_non_digit_string_if_not_strict(bool $paranoid): void
    {
        $numberObject = new NumberObject('some string without digits', false /* not strict */, $paranoid);
        self::assertSame(0, $numberObject->getValue());
    }

    /**
     * @test
     * @dataProvider provideStrictnessAndParanoia
     * @param bool $strict
     * @param bool $paranoid
     */
    public function I_get_number_without_wrapping_trash(bool $strict, bool $paranoid): void
    {
        $withWrappingZeroes = new NumberObject($zeroWrappedNumber = '0000123456.789000', $strict, $paranoid);
        self::assertSame(123456.789, $withWrappingZeroes->getValue());
        self::assertSame((float)$zeroWrappedNumber, $withWrappingZeroes->getValue());
        $integerLike = new NumberObject($integerLikeNumber = '0000123456.0000', $strict, $paranoid);
        self::assertSame(123456, $integerLike->getValue());
        self::assertSame((int)$integerLikeNumber, $integerLike->getValue());
    }

    /**
     * @test
     * @dataProvider provideParanoia
     * @param bool $paranoid
     */
    public function I_get_number_without_tailing_non_zero_trash_if_not_strict(bool $paranoid): void
    {
        $trashAround = new NumberObject($trashWrappedNumber = '   123456.0051500  foo bar 12565.04181 ', false /* not strict */, $paranoid);
        self::assertSame(123456.00515, $trashAround->getValue());
        self::assertSame((float)$trashWrappedNumber, $trashAround->getValue());
    }

    /**
     * @test
     * @expectedException \Granam\Number\Tools\Exceptions\WrongParameterType
     */
    public function I_can_not_use_value_with_trailing_non_zero_trash_by_default(): void
    {
        new NumberObject($trashWrappedNumber = '123456.0051500  foo bar 12565.04181 ');
    }

    /**
     * @test
     */
    public function I_can_use_value_wrapped_by_white_characters(): void
    {
        $numberObject = new NumberObject($trashWrappedNumber = " \n\t\r\r 123456.0051500 \t\t\n\r\r  ");
        self::assertSame(123456.0051500, $numberObject->getValue());
    }

    /**
     * @test
     * @dataProvider provideStrictness
     * @param bool $strict
     */
    public function I_get_silently_rounded_number_by_default(bool $strict): void
    {
        $smallFloat = new NumberObject($withTooLongDecimal = '123456.999999999999999999999999999999999999', $strict);
        self::assertSame(123457, $smallFloat->getValue());
        self::assertSame((int)(float)$withTooLongDecimal, $smallFloat->getValue());
        $explicitlyNonParanoidSmallFloat = new NumberObject($withTooLongDecimal, $strict, false);
        self::assertEquals($smallFloat, $explicitlyNonParanoidSmallFloat);
        $largeFloat = new NumberObject($withTooLongInteger = '222222222222222222222222222222222222222222.123', $strict);
        self::assertSame(2.2222222222222224E+41, $largeFloat->getValue());
        self::assertSame((float)$withTooLongInteger, $largeFloat->getValue());
        $explicitlyNonParanoidLargeFloat = new NumberObject($withTooLongInteger, $strict, false);
        self::assertEquals($largeFloat, $explicitlyNonParanoidLargeFloat);
    }

    public function provideStrictness(): array
    {
        return [
            [true],
            [false],
        ];
    }

    /**
     * @test
     * @expectedException \Granam\Number\Tools\Exceptions\ValueLostOnCast
     * @dataProvider provideStrictness
     * @param bool $strict
     */
    public function I_can_force_exception_on_rounding(bool $strict): void
    {
        $nothingIsLost = new NumberObject($value = '123456.9999999', $strict, true /* paranoid */);
        self::assertSame((float)$value, $nothingIsLost->getValue());
        new NumberObject('123456.999999999999999999999999999999999999', $strict, true /* paranoid */);
        self::fail('Paranoid test failed'); // should never reach it because of previous exception
    }

    /**
     * @test
     */
    public function I_can_create_new_number_by_adding_value(): void
    {
        $number = new NumberObject(123);
        $increased = $number->add(456);
        self::assertSame(123, $number->getValue());
        self::assertSame(579, $increased->getValue());
        self::assertNotEquals($number, $increased);
        $increasedMore = $increased->add($number);
        self::assertSame(702, $increasedMore->getValue());
    }

    /**
     * @test
     */
    public function I_can_create_new_number_by_subtracting_value(): void
    {
        $number = new NumberObject(123);
        $decreased = $number->sub(456);
        self::assertSame(123, $number->getValue());
        self::assertSame(-333, $decreased->getValue());
        self::assertNotEquals($number, $decreased);
        $decreasedMore = $decreased->sub($decreased); // minus minus
        self::assertSame(0, $decreasedMore->getValue());
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