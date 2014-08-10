<?php

namespace tests\Stubs;

/**
 * @codeCoverageIgnore
 */
class MapperSourceStub
{
    private $testField1;

    private $testField2;

    private $testField3;

    private $testField4;

    /**
     * @param mixed $testField1
     * @return $this
     */
    public function setTestField1($testField1)
    {
        $this->testField1 = $testField1;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTestField1()
    {
        return $this->testField1;
    }

    /**
     * @param mixed $testField2
     * @return $this
     */
    public function setTestField2($testField2)
    {
        $this->testField2 = $testField2;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTestField2()
    {
        return $this->testField2;
    }

    /**
     * @param mixed $testField3
     * @return $this
     */
    public function setTestField3($testField3)
    {
        $this->testField3 = $testField3;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTestField3()
    {
        return $this->testField3;
    }

    /**
     * @param mixed $testField4
     * @return $this
     */
    public function setTestField4($testField4)
    {
        $this->testField4 = $testField4;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTestField4()
    {
        return $this->testField4;
    }
}
