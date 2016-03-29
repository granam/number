<?php
namespace Granam\Tests\Number;

use Granam\Tests\Exceptions\Tools\AbstractExceptionsHierarchyTest;

class ExceptionHierarchyTest extends AbstractExceptionsHierarchyTest
{
    protected function getTestedNamespace()
    {
        return $this->getRootNamespace();
    }

    protected function getRootNamespace()
    {
        return str_replace('\Tests', '', __NAMESPACE__);
    }

    protected function getExternalRootNamespaces()
    {
        $externalRootReflection = new \ReflectionClass('\Granam\Scalar\ScalarInterface');

        return $externalRootReflection->getNamespaceName();
    }
}
