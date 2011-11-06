<?php

require_once "phing/types/DataType.php";

class SoapClientType extends DataType
{
    /**
     * URL to WSDL
     *
     * @var string
     */
    protected $wsdl;

    /**
     * @var SoapClient
     */
    protected $soapClient;

    /**
     * @param string $wsdl
     */
    public function setWsdl($wsdl)
    {
        $this->wsdl = $wsdl;
    }

    /**
     * @return string
     */
    public function getWsdl()
    {
        return $this->wsdl;
    }

    /**
     * @param Project $p
     * @return SoapClient
     */
    public function getClient($p)
    {
        if ($this->isReference()) {
            return $this->getRef($p)->getClient($p);
        }
        if ($this->soapClient == null) {
            $this->soapClient = new SoapClient($this->wsdl);
        }
        return $this->soapClient;
    }

    /**
     * @param Project $p
     * @return SoapClientType
     */
    public function getRef(Project $p)
    {
        if (!$this->checked) {
            $stk = array();
            array_push($stk, $this);
            $this->dieOnCircularReference($stk, $p);
        }
        $o = $this->ref->getReferencedObject($p);
        if ( !($o instanceof SoapClientType) ) {
            throw new BuildException($this->ref->getRefId()." doesn't denote a SoapClient");
        } else {
            return $o;
        }
    }

}