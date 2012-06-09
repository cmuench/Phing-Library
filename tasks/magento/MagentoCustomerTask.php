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

require_once __DIR__ . '/AbstractMagentoTask.php';

/**
 * @author Christian Münch <c.muench@netz98.de>
 */
class MagentoCustomerTask extends AbstractMagentoTask
{
    /**
     * @var string
     */
    protected $_email;

    /**
     * @var string
     */
    protected $_firstname;

    /**
     * @var string
     */
    protected $_lastname;

    /**
     * @var string
     */
    protected $_password;

    /**
     * @param string $firstname
     */
    public function setFirstname($firstname)
    {
        $this->_firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getFirstname()
    {
        return $this->_firstname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname($lastname)
    {
        $this->_lastname = $lastname;
    }

    /**
     * @return string
     */
    public function getLastname()
    {
        return $this->_lastname;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->_password = $password;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->_password;
    }


    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->_email = $email;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->_email;
    }

    public function main()
    {
        parent::main();
        $customer = Mage::getModel('customer/customer');
        $customer->setWebsiteId($this->getWebsiteId());
        $customer->loadByEmail($this->_email);
        $this->log('Load customer: ' . $this->_email . ' -> ' . $this->getWebsiteId());

        if (!$customer->getId()) {

            $customer->setWebsiteId($this->getWebsiteId());
            $customer->setEmail($this->_email);
            $customer->setFirstname($this->_firstname);
            $customer->setLastname($this->_lastname);
            $customer->setPassword($this->_password);
        }

        try {
            $customer->save();
            $customer->setConfirmation(null);
            $customer->save();
        } catch (Exception $e) {
            $this->log($this->_email . ' -> ' . $this->getWebsiteId() . ': ' . $e->getMessage(), Project::MSG_ERR);
        }
    }
}
