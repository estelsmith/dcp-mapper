<?php

namespace DCP\Mapper;

use DCP\Mapper\Exception\InvalidArgumentException;
use DCP\Mapper\Collections\Maps\TransformerMap;

class ObjectMapper implements MapperInterface
{
    /**
     * @var RuleMap
     */
    private $ruleMap;

    /**
     * @var TransformerMap
     */
    private $transformerMap;

    public function __construct(RuleMap $ruleMap, TransformerMap $transformerMap)
    {
        $this->ruleMap = $ruleMap;
        $this->transformerMap = $transformerMap;
    }

    public function map($source, $target)
    {
        if (!is_object($source)) {
            throw new InvalidArgumentException('$source must be an object');
        }

        if (!is_object($target)) {
            throw new InvalidArgumentException('$target must be an object');
        }

        $sourceClass = new \ReflectionClass($source);
        $targetClass = new \ReflectionClass($target);

        $sourceGetters = $this->findGetterMethods($sourceClass);

        foreach ($sourceGetters as $getter) {
            $getterPropertyName = lcfirst(substr($getter->getName(), 3)); // getLastName -> lastName

            if (!$this->processPropertyRules($getterPropertyName)) {
                continue;
            }

            $setterMethodName = 'set' . ucfirst($getterPropertyName); // lastName -> setLastName

            if (!$targetClass->hasMethod($setterMethodName)) {
                continue;
            }

            $setter = $targetClass->getMethod($setterMethodName);

            $propertyValue = $getter->invoke($source);
            $propertyValue = $this->processPropertyTransformers($getterPropertyName, $propertyValue);

            $setter->invokeArgs($target, [$propertyValue]);
        }

        return $target;
    }

    private function findGetterMethods(\ReflectionClass $class)
    {
        $methods = $class->getMethods(\ReflectionMethod::IS_PUBLIC);

        return $this->filterMethodsWithPrefix($methods, 'get');
    }

    /**
     * @param \ReflectionMethod[] $methods
     * @param string $prefix
     * @return \ReflectionMethod[]
     */
    private function filterMethodsWithPrefix($methods, $prefix)
    {
        $result = [];

        foreach ($methods as $method) {
            $methodName = $method->getName();

            if (strpos($methodName, $prefix) === 0) {
                $result[] = $method;
            }
        }

        return $result;
    }

    private function processPropertyRules($property)
    {
        $rules = $this->ruleMap->getRules($property);

        $proceed = true;

        foreach ($rules as $rule) {
            if (!$rule->execute()) {
                $proceed = false;
                break;
            }
        }

        return $proceed;
    }

    private function processPropertyTransformers($property, $value)
    {
        $transformers = $this->transformerMap->get($property);

        $result = $value;

        foreach ($transformers as $transformer) {
            $result = $transformer->transform($result);
        }

        return $result;
    }
}
