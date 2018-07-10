<?php
declare(strict_types=1);

namespace Granam\Tests\Number;

use Granam\Scalar\ScalarInterface;
use Granam\Tests\ExceptionsHierarchy\Exceptions\AbstractExceptionsHierarchyTest;

class NumberExceptionsHierarchyTest extends AbstractExceptionsHierarchyTest
{
    protected function getTestedNamespace(): string
    {
        return $this->getRootNamespace();
    }

    protected function getRootNamespace(): string
    {
        return \str_replace('\Tests', '', __NAMESPACE__);
    }

    /**
     * @return string
     * @throws \ReflectionException
     */
    protected function getExternalRootNamespaces(): string
    {
        $externalRootReflection = new \ReflectionClass(ScalarInterface::class);

        return $externalRootReflection->getNamespaceName();
    }
}