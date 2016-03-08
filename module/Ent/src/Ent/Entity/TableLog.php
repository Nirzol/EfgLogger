<?php

namespace Ent\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EfgLogger
 *
 * @ORM\Table(name="table_log")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity
 */
class TableLog
{

    /**
     * @var integer
     *
     * @ORM\Column(name="log_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $logId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="log_datetime", type="datetime", nullable=true)
     */
    private $logDatetime;

    /**
     * @var integer
     *
     * @ORM\Column(name="log_priority", type="integer", nullable=false)
     */
    private $logPriority;

    /**
     * @var string
     *
     * @ORM\Column(name="log_priority_name", type="string", nullable=false)
     */
    private $logPriorityName;

    /**
     * @var string
     *
     * @ORM\Column(name="log_login", type="string", length=80, nullable=false)
     */
    private $logLogin;

    /**
     * @var string
     *
     * @ORM\Column(name="log_session", type="string", length=80, nullable=false)
     */
    private $logSession;

    /**
     * @var string
     *
     * @ORM\Column(name="log_ip", type="string", length=15, nullable=false)
     */
    private $logIp;

    /**
     * @var string
     *
     * @ORM\Column(name="log_useragent", type="text", nullable=false)
     */
    private $logUseragent;

    /**
     * @var integer
     *
     * @ORM\Column(name="log_action", type="integer", nullable=false)
     */
    private $logAction;

    /**
     * @var string
     *
     * @ORM\Column(name="log_action_name", type="string", nullable=false)
     */
    private $logActionName;

    /**
     * @var string
     *
     * @ORM\Column(name="log_message", type="text", nullable=false)
     */
    protected $logMessage;

    /**
     * @var string
     *
     * @ORM\Column(name="log_url", type="text", nullable=false)
     */
    protected $logUrl;

    /**
     * Get logId
     *
     * @return integer
     */
    public function getLogId()
    {
        return $this->logId;
    }

    /**
     * Get logPriority
     *
     * @return integer
     */
    public function getLogPriority()
    {
        return $this->logPriority;
    }

    /**
     * Set logPriority
     *
     * @param integer $logPriority
     */
    public function setLogPriority($logPriority)
    {
        $this->logPriority = $logPriority;
    }

    /**
     * Get logPriorityName
     *
     * @return string
     */
    public function getLogPriorityName()
    {
        return $this->logPriorityName;
    }

    /**
     * Set logPriorityName
     *
     * @param string $logPriorityName
     */
    public function setLogPriorityName($logPriorityName)
    {
        $this->logPriorityName = $logPriorityName;
    }

    /**
     * Get logAction
     *
     * @return integer
     */
    public function getLogAction()
    {
        return $this->logAction;
    }

    /**
     * Set logAction
     *
     * @param integer $logAction
     */
    public function setLogAction($logAction)
    {
        $this->logAction = $logAction;
    }

    /**
     * Get logActionName
     *
     * @return string
     */
    public function getLogActionName()
    {
        return $this->logActionName;
    }

    /**
     * Set logActionName
     *
     * @param string $logActionName
     */
    public function setLogActionName($logActionName)
    {
        $this->logActionName = $logActionName;
    }

    /**
     * Get logMessage
     *
     * @return string
     */
    public function getLogMessage()
    {
        return $this->logMessage;
    }

    /**
     * Set logMessage
     *
     * @param string $logMessage
     */
    public function setLogMessage($logMessage)
    {
        $this->logMessage = $logMessage;
    }

    /**
     * Get logUrl
     *
     * @return string
     */
    public function getLogUrl()
    {
        return $this->logUrl;
    }

    /**
     * Set logUrl
     *
     * @param string $logUrl
     */
    public function setLogUrl($logUrl)
    {
        $this->logUrl = $logUrl;
    }

    /**
     * Set logLogin
     *
     * @param string $logLogin
     *
     * @return EntLog
     */
    public function setLogLogin($logLogin)
    {
        $this->logLogin = $logLogin;

        return $this;
    }

    /**
     * Get logLogin
     *
     * @return string
     */
    public function getLogLogin()
    {
        return $this->logLogin;
    }

    /**
     * Set logSession
     *
     * @param string $logSession
     *
     * @return EntLog
     */
    public function setLogSession($logSession)
    {
        $this->logSession = $logSession;

        return $this;
    }

    /**
     * Get logSession
     *
     * @return string
     */
    public function getLogSession()
    {
        return $this->logSession;
    }

    /**
     * Set logIp
     *
     * @param string $logIp
     *
     * @return EntLog
     */
    public function setLogIp($logIp)
    {
        $this->logIp = $logIp;

        return $this;
    }

    /**
     * Get logIp
     *
     * @return string
     */
    public function getLogIp()
    {
        return $this->logIp;
    }

    /**
     * Set logUseragent
     *
     * @param string $logUseragent
     *
     * @return EntLog
     */
    public function setLogUseragent($logUseragent)
    {
        $this->logUseragent = $logUseragent;

        return $this;
    }

    /**
     * Get logUseragent
     *
     * @return string
     */
    public function getLogUseragent()
    {
        return $this->logUseragent;
    }

    /**
     * Set logDatetime
     *
     * @param \DateTime $logDatetime
     *
     * @return EntLog
     */
    public function setLogDatetime($logDatetime)
    {
        $this->logDatetime = $logDatetime;

        return $this;
    }

    /**
     * Get logDatetime
     *
     * @return \DateTime
     */
    public function getLogDatetime()
    {
        return $this->logDatetime;
    }

    /**
     * Now we tell doctrine that before we persist or update we call the updatedTimestamps() function.
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps()
    {
//        $this->setLogDatetime(date_create(date('Y-m-d H:i:s'))); //date('Y-m-d H:i:s')  new \DateTime("now")
        if ($this->getLogDatetime() == null) {
            $this->setLogDatetime(date_create(date('Y-m-d H:i:s')));
        }
    }

    public function exchangeArray(array $array)
    {
        foreach ($array as $key => $value) {
            $this->set($key, $value);
        }
    }

    private function set($key, $value)
    {
        $workKey = $key;
        //fix underscore
        if (strpos($workKey, "_") !== false) {
            $workKey = preg_replace_callback('/_(.?)/', function ($a) {
                return strtoupper($a[1]);
            }, $key);
        }
//        var_dump($this, $workKey);
        if (property_exists($this, $workKey)) {
            $setter = "set" . ucfirst($workKey);
            if (method_exists($this, $setter)) {
                $this->$setter($value);
            }
        }
    }
}
