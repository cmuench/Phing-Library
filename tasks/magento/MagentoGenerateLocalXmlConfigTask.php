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
 * Generates a magento local.xml configuration in folder app/etc.
 *
 * @author Christian Münch <c.muench@netz98.de>
 */
class MagentoGenerateLocalXmlConfigTask extends AbstractMagentoTask
{
    /**
     * Overwrite existing local xml file.
     *
     * @var bool
     */
    protected $_overwrite = false;

    /**
     * @var string
     */
    protected $_date = '';

    /**
     * @var string
     */
    protected $_key = '';

    /**
     * @var string
     */
    protected $_dbPrefix = '';

    /**
     * @var string
     */
    protected $_dbHost = '';

    /**
     * @var string
     */
    protected $_dbUser = '';

    /**
     * @var string
     */
    protected $_dbPass = '';

    /**
     * @var string
     */
    protected $_dbName = '';

    /**
     * @var string
     */
    protected $_dbInitStatements = 'SET NAMES utf8';

    /**
     * @var string
     */
    protected $_dbModel = 'mysql4';

    /**
     * @var string
     */
    protected $_dbType = 'pdo_mysql';

    /**
     * @var string
     */
    protected $_dbPdoType = '';

    /**
     * @var string
     */
    protected $_sessionSave = 'files';

    /**
     * @var string
     */
    protected $_adminFrontname = 'admin';

    /**
     * Main task logic
     */
    public function main()
    {
        $templateFilename = $this->getMagentoRootDirectory() . '/app/etc/local.xml.template';

        if (!$this->_overwrite && is_file($this->getMagentoRootDirectory() . '/app/etc/local.xml')) {
            $this->log('app/etc/local.xml already exists. Skip overwrite.', Project::MSG_INFO);
            return;
        }
        if (!is_file($templateFilename)) {
            $this->log('app/etc/local.xml.template was not found', Project::MSG_ERR);
            return;
        }
        if (!is_writable($this->getMagentoRootDirectory() . '/app/etc')) {
            $this->log('Folder ' . $this->getMagentoRootDirectory() . '/app/etc is not writeable', Project::MSG_ERR);
            return;
        }
        $content = file_get_contents($templateFilename);

        $replace = array(
            '{{date}}'               => $this->getDate(),
            '{{key}}'                => $this->getKey(),
            '{{db_prefix}}'          => $this->_dbPrefix,
            '{{db_host}}'            => $this->_dbHost,
            '{{db_user}}'            => $this->_dbUser,
            '{{db_pass}}'            => $this->_dbPass,
            '{{db_name}}'            => $this->_dbName,
            '{{db_init_statemants}}' => $this->_dbInitStatements, // this is right -> magento has a little typo bug "statemants".
            '{{db_model}}'           => $this->_dbModel,
            '{{db_type}}'            => $this->_dbType,
            '{{db_pdo_type}}'        => $this->_dbPdoType,
            '{{session_save}}'       => $this->_sessionSave,
            '{{admin_frontname}}'    => $this->_adminFrontname,
        );

        $newFileContent = str_replace(array_keys($replace), array_values($replace), $content);
        file_put_contents($this->getMagentoRootDirectory() . '/app/etc/local.xml', $newFileContent);
    }

    /**
     * @param boolean $overwrite
     */
    public function setOverwrite($overwrite)
    {
        $this->_overwrite = (bool) $overwrite;
    }

    /**
     * @return boolean
     */
    public function getOverwrite()
    {
        return $this->_overwrite;
    }

    /**
     * @param string $adminFrontname
     */
    public function setAdminFrontname($adminFrontname)
    {
        $this->_adminFrontname = $adminFrontname;
    }

    /**
     * @return string
     */
    public function getAdminFrontname()
    {
        return $this->_adminFrontname;
    }

    /**
     * @param string $dbHost
     */
    public function setDbHost($dbHost)
    {
        $this->_dbHost = $dbHost;
    }

    /**
     * @return string
     */
    public function getDbHost()
    {
        return $this->_dbHost;
    }

    /**
     * @param string $dbInitStatements
     */
    public function setDbInitStatements($dbInitStatements)
    {
        $this->_dbInitStatements = $dbInitStatements;
    }

    /**
     * @return string
     */
    public function getDbInitStatements()
    {
        return $this->_dbInitStatements;
    }

    /**
     * @param string $dbModel
     */
    public function setDbModel($dbModel)
    {
        $this->_dbModel = $dbModel;
    }

    /**
     * @return string
     */
    public function getDbModel()
    {
        return $this->_dbModel;
    }

    /**
     * @param string $dbName
     */
    public function setDbName($dbName)
    {
        $this->_dbName = $dbName;
    }

    /**
     * @return string
     */
    public function getDbName()
    {
        return $this->_dbName;
    }

    /**
     * @param string $dbPass
     */
    public function setDbPass($dbPass)
    {
        $this->_dbPass = $dbPass;
    }

    /**
     * @return string
     */
    public function getDbPass()
    {
        return $this->_dbPass;
    }

    /**
     * @param string $dbPdoType
     */
    public function setDbPdoType($dbPdoType)
    {
        $this->_dbPdoType = $dbPdoType;
    }

    /**
     * @return string
     */
    public function getDbPdoType()
    {
        return $this->_dbPdoType;
    }

    /**
     * @param string $dbType
     */
    public function setDbType($dbType)
    {
        $this->_dbType = $dbType;
    }

    /**
     * @return string
     */
    public function getDbType()
    {
        return $this->_dbType;
    }

    /**
     * @param string $dbUser
     */
    public function setDbUser($dbUser)
    {
        $this->_dbUser = $dbUser;
    }

    /**
     * @return string
     */
    public function getDbUser()
    {
        return $this->_dbUser;
    }

    /**
     * @param string $date
     */
    public function setDate($date)
    {
        $this->_date = $date;
    }

    /**
     * @return string
     */
    public function getDate()
    {
        if (empty($this->_date)) {
            return date(DateTime::RFC2822);
        }
        return $this->_date;
    }

    /**
     * @param string $dbPrefix
     */
    public function setDbPrefix($dbPrefix)
    {
        $this->_dbPrefix = $dbPrefix;
    }

    /**
     * @return string
     */
    public function getDbPrefix()
    {
        return $this->_dbPrefix;
    }

    /**
     * @param string $key
     */
    public function setKey($key)
    {
        $this->_key = $key;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        if (empty($this->_key)) {
            return md5(uniqid());
        }
        return $this->_key;
    }

    /**
     * @param string $sessionSave
     */
    public function setSessionSave($sessionSave)
    {
        $this->_sessionSave = $sessionSave;
    }

    /**
     * @return string
     */
    public function getSessionSave()
    {
        return $this->_sessionSave;
    }
}
