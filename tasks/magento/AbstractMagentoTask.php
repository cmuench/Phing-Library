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
 * @author Christian Münch <c.muench@netz98.de>
 */
abstract class AbstractMagentoTask extends Task
{
    /**
     * Store code
     *
     * @var string
     */
    protected $_store;

    /**
     * @var string
     */
    protected $_magentoRootDirectory = null;

    /**
     * @return string
     */
    public function getMagentoRootDirectory()
    {
        if (empty($this->_magentoRootDirectory)) {
            return realpath(__DIR__ . '/../../../../');
        }
        return $this->_magentoRootDirectory;
    }
    public function main()
    {
        if (!class_exists('Mage')) {
            require_once $this->getMagentoRootDirectory() . '/app/Mage.php';
        }
        Mage::app($this->_store);
    }

    /**
     * @param string $directory
     */
    public function setMagentoRoot($directory)
    {
        $this->_magentoRootDirectory = rtrim($directory, DIRECTORY_SEPARATOR);
    }

    /**
     * @param string $store
     */
    public function setStore($store)
    {
        $this->_store = $store;
    }

    /**
     * @return string
     */
    public function getStore()
    {
        return $this->_store;
    }

    /**
     * @return int|null
     */
    protected function getWebsiteId()
    {
        return Mage::app()->getStore($this->_store)->getWebsiteId();
    }
}