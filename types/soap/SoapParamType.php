<?php

require_once "phing/types/DataType.php";

/**
 * Parameter used by a soap call
 *
 * @author Christian Münch <christian@muench-worms.de>
 */
class SoapParamType extends DataType
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $value;

    /**
     * Supporting the <soapparam>value</soapparam> syntax.
     *
     * @param string
     * @return void
     */
    public function addText($msg)
    {
        $this->value = $msg;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
}