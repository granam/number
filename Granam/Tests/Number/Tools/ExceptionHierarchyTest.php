<?php
namespace Granam\Number\Tools;

use Granam\Exceptions\Tests\Tools\AbstractTestOfExceptionsHierarchy;

class ExceptionHierarchyTest extends AbstractTestOfExceptionsHierarchy
{
    protected function getTestedNamespace()
    {
        return __NAMESPACE__;
    }

    protected function getRootNamespace()
    {
        return $this->getTestedNamespace();
    }

}
