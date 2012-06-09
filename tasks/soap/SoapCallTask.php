<?php
/**
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the LGPL. For more information please see
 *
 * <http://www.opensource.org/licenses/lgpl-3.0.html>.
 */

require_once 'phing/Task.php';

/**
 * Task to call a remote SOAP webservice
 *
 * @author Christian Münch <c.muench@netz98.de>
 */
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
            $result = $soapClient->{$this->method}($this->_getCallParameterArray());
            $this->getProject()->setProperty($this->property, json_encode($result));
        } catch (Exception $e) {
            $this->log($e->getMessage(), Project::MSG_ERR);
        }
    }
}