<?php
namespace Granam\Tests\Number;

abstract class ICanUseItSameWayAsUsing extends \PHPUnit_Framework_TestCase
{
    protected function I_can_create_it_same_way_as_using()
    {
        $numberObjectReflection = new \ReflectionClass('\Granam\Number\NumberObject');
        $numberConstructor = $numberObjectReflection->getConstructor()->getParameters();
        $toNumberClassReflection = new \ReflectionClass('\Granam\Number\Tools\ToNumber');
        $toNumberParameters = $toNumberClassReflection->getMethod('toNumber')->getParameters();
        self::assertEquals(
            $this->extractParametersDetails($toNumberParameters),
            $this->extractParametersDetails($numberConstructor)
        );
        foreach ($numberConstructor as $index => $constructorParameter) {
            $toNumberParameter = $toNumberParameters[$index];
            self::assertEquals($toNumberParameter, $constructorParameter);
            self::assertSame($toNumberParameter->isOptional(), $constructorParameter->isOptional());
            self::assertSame($toNumberParameter->allowsNull(), $constructorParameter->allowsNull());
            self::assertSame($toNumberParameter->isDefaultValueAvailable(), $constructorParameter->isDefaultValueAvailable());
            if ($constructorParameter->isDefaultValueAvailable()) {
                self::assertSame($toNumberParameter->getDefaultValue(), $constructorParameter->getDefaultValue());
            }
            self::assertSame($toNumberParameter->getName(), $constructorParameter->getName());
        }
    }

    /**
     * @param array|\ReflectionParameter[] $parameterReflections
     * @return array
     */
    private function extractParametersDetails(array $parameterReflections)
    {
        $extracted = [];
        foreach ($parameterReflections as $parameterReflection) {
            $extractedParameter = [];
            foreach (get_class_methods($parameterReflection) as $methodName) {
                if (in_array($methodName, ['getName', 'isPassedByReference', 'canBePassedByValue', 'isArray',
                        'isCallable', 'allowsNull', 'getPosition', 'isOptional', 'isDefaultValueAvailable',
                        'getDefaultValue', 'isVariadic'], true)
                    && ($methodName !== 'getDefaultValue' || $parameterReflection->isDefaultValueAvailable())
                ) {
                    $extractedParameter[$methodName] = $parameterReflection->$methodName();
                }
            }
            $extracted[] = $extractedParameter;
        }

        return $extracted;
    }

    protected function assertUsableWithJustValueParameter($sutClass, $testedMethod)
    {
        $classReflection = new \ReflectionClass($sutClass);
        $method = $classReflection->getMethod($testedMethod);
        self::assertSame(1, $method->getNumberOfRequiredParameters());
    }
}
