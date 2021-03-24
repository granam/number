<?php declare(strict_types=1);

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

    protected function getRootNamespace(): string
    {
        $rootReflection = new \ReflectionClass(NumberObject::class);

        return $rootReflection->getNamespaceName();
    }

    protected function getExternalRootNamespaces(): array
    {
        $externalRootException = new \ReflectionClass(ScalarInterface::class);

        return [$externalRootException->getNamespaceName()];
    }

}
