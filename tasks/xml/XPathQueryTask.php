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
 * Runs an xpath query on a xml and stores result in a property
 *
 * @author Christian Münch <c.muench@netz98.de>
 */
class XPathQueryTask extends Task
{
    /**
     * @var string
     */
    protected $property;

    /**
     * @var $query
     */
    protected $query;

    /**
     * @var string
     */
    protected $value = '';

    /**
     * Run query
     */
    public function main()
    {
        if (empty($this->query)) {
            throw new BuildException('Query (xpath) was not set.');
        }
        if (empty($this->value)) {
            throw new BuildException('No XML was given was value.');
        }
        if (empty($this->property)) {
            throw new BuildException('No property was set.');
        }
        try {
            $xml = simplexml_load_string($this->value);
            $result = $xml->xpath($this->query);
            if (count($result) > 1) {
                throw new BuildException('Query should only return one value. We can only save one value in a property.');
            }
            $this->getProject()->setProperty($this->property, (string) $result[0]);
        } catch (Exception $e) {
            $this->log($e->getMessage(), Project::MSG_ERR);
        }
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

    /**
     * Supporting the <xpathquery>value</xpathquery> syntax.
     *
     * @param string
     * @return void
     */
    public function addText($msg)
    {
        $this->value = $msg;
    }

    /**
     * @param  $query
     */
    public function setQuery($query)
    {
        $this->query = $query;
    }

    /**
     * @return
     */
    public function getQuery()
    {
        return $this->query;
    }
}