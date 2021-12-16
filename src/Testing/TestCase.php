<?php

declare(strict_types=1);

namespace Insly\Identifier\Client\Testing;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

class TestCase extends PHPUnitTestCase
{
    /**
     * @throws ReflectionException
     */
    protected function getProtectedMethod(string $className, string $methodName): ReflectionMethod
    {
        $mockedClass = new ReflectionClass($className);
        $method = $mockedClass->getMethod($methodName);
        $method->setAccessible(true);

        return $method;
    }
}
