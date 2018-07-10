<?php
declare(strict_types = 1);

namespace Granam\Tests\Number\Tools;

use Granam\Number\NumberObject;
use Granam\Scalar\ScalarInterface;
use Granam\Tests\ExceptionsHierarchy\Exceptions\AbstractExceptionsHierarchyTest;

class NumberExceptionsHierarchyTest extends AbstractExceptionsHierarchyTest
{
    protected function getTestedNamespace(): string
    {
        return \str_replace('\Tests', '', __NAMESPACE__);
    }

    /**
     * @throws \ReflectionException
     */
    protected function getRootNamespace(): string
    {
        $rootReflection = new \ReflectionClass(NumberObject::class);

        return $rootReflection->getNamespaceName();
    }

    /**
     * @throws \ReflectionException
     */
    protected function getExternalRootNamespaces(): string
    {
        $externalRootException = new \ReflectionClass(ScalarInterface::class);

        return $externalRootException->getNamespaceName();
    }

}