<?php
namespace Granam\Tests\Number\Tools;

use Granam\Number\NumberObject;
use Granam\Tests\Exceptions\Tools\AbstractExceptionsHierarchyTest;

class ExceptionHierarchyTest extends AbstractExceptionsHierarchyTest
{
    protected function getTestedNamespace()
    {
        return str_replace('\Tests', '', __NAMESPACE__);
    }

    protected function getRootNamespace()
    {
        $rootReflection = new \ReflectionClass(NumberObject::getClass());

        return $rootReflection->getNamespaceName();
    }

}
