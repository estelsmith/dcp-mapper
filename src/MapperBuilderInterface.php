<?php

namespace DCP\Mapper;

interface MapperBuilderInterface
{
    /**
     * @return $this
     */
    public function reset();

    /**
     * @param string $field
     * @param RuleInterface $rule
     * @return $this
     */
    public function addRule($field, RuleInterface $rule);

    /**
     * @param string $field
     * @param TransformerInterface $transformer
     * @return $this
     */
    public function addTransformer($field, TransformerInterface $transformer);

    /**
     * @return MapperInterface
     */
    public function getMapper();
}
