<?php
namespace Granam\Tests\Number;

use Granam\Number\Tools\ToNumber;
use Granam\Number\NumberObject;
use Granam\Tests\Tools\TestWithMockery;

abstract class ICanUseItSameWayAsUsing extends TestWithMockery
{
    protected function I_can_create_it_same_way_as_using()
    {
        $numberObjectReflection = new \ReflectionClass(NumberObject::class);
        $numberConstructor = $numberObjectReflection->getConstructor()->getParameters();
        $toNumberClassReflection = new \ReflectionClass(ToNumber::class);
        $toNumberParameters = $toNumberClassReflection->getMethod('toNumber')->getParameters();
        self::assertEquals(
            $this->extractParametersDetails($toNumberParameters),
            $this->extractParametersDetails($numberConstructor),
            'Method ' .ToNumber::class . '::toNumber si called differently than constructor of ' . NumberObject::class
        );
    }

    /**
     * @param array|\ReflectionParameter[] $parameterReflections
     * @return array
     */
    private function extractParametersDetails(array $parameterReflections): array
    {
        $extracted = [];
        foreach ($parameterReflections as $parameterReflection) {
            $extractedParameter = [];
            foreach (get_class_methods($parameterReflection) as $methodName) {
                if (\in_array($methodName, ['getName', 'isPassedByReference', 'canBePassedByValue', 'isArray',
                        'isCallable', 'allowsNull', 'getPosition', 'isOptional', 'isDefaultValueAvailable',
                        'getDefaultValue', 'isVariadic', 'hasType', 'getType'], true)
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