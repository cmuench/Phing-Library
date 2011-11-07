<?php

require_once 'phing/Task.php';

class SoapCallTask extends Task
{
    /**
     * @var string
     */
    protected $method;

    /**
     * @var array
     */
    protected $params = array();

    /**
     * @var string
     */
    protected $property;

    /**
     * @var SoapClientType
     */
    protected $soapClient;

    /**
     * @param string $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $property
     */
    public function setProperty($property)
    {
        $this->property = $property;
    }

    /**
     * @return string
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * Creates internal soap client object
     *
     *  @return SoapClientType
     */
    public function createSoapclient()
    {
        $this->soapClient = new SoapClientType($this->getProject());
        return $this->soapClient;
    }

    /**
     * Adds a param for soap call
     *
     * @return SoapParamType
     */
    public function createSoapparam()
    {
        $param = new SoapParamType($this->getProject());
        $this->params[] = $param;
        return $param;
    }

    /**
     * @return array
     */
    protected function _getCallParameterArray()
    {
        $array = array();
        foreach ($this->params as $param) {
            $array[$param->getName()] = $param->getValue();
        }
        return $array;
    }

    /**
     * Call soap server
     */
    public function main()
    {
        try {
            $soapClient = $this->soapClient->getClient($this->getProject());
            $returnValue = $soapClient->{$this->method}($this->_getCallParameterArray());
            if (is_object($returnValue)) {
                // @TODO How should be store and access objects as return value?
                $this->getProject()->setProperty($this->property, json_encode($returnValue));
            } else {
                $this->getProject()->setProperty($this->property, $returnValue);
            }
        } catch (Exception $e) {
            $this->log($e->getMessage(), Project::MSG_ERR);
        }
    }
}