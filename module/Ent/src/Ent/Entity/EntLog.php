<?php

namespace Ent\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EntLog
 *
 * @ORM\Table(name="ent_log", indexes={@ORM\Index(name="fk_module_id", columns={"fk_log_module_id"}), @ORM\Index(name="fk_action_id", columns={"fk_log_action_id"}), @ORM\Index(name="fk_user_id", columns={"fk_log_user_id"})})
 * @ORM\Entity
 */
class EntLog extends Ent
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
     * @var string
     *
     * @ORM\Column(name="log_login", type="string", length=80, nullable=false)
     */
    private $logLogin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="log_online", type="datetime", nullable=false)
     */
    private $logOnline;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="log_offline", type="datetime", nullable=true)
     */
    private $logOffline;

    /**
     * @var string
     *
     * @ORM\Column(name="log_session", type="string", length=40, nullable=false)
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
     * @var \DateTime
     *
     * @ORM\Column(name="log_datetime", type="datetime", nullable=false)
     */
    private $logDatetime = 'CURRENT_TIMESTAMP';

    /**
     * @var \Ent\Entity\EntModule
     *
     * @ORM\ManyToOne(targetEntity="Ent\Entity\EntModule")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_log_module_id", referencedColumnName="module_id")
     * })
     */
    private $fkLogModule;

    /**
     * @var \Ent\Entity\EntUser
     *
     * @ORM\ManyToOne(targetEntity="Ent\Entity\EntUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_log_user_id", referencedColumnName="user_id")
     * })
     */
    private $fkLogUser;

    /**
     * @var \Ent\Entity\EntAction
     *
     * @ORM\ManyToOne(targetEntity="Ent\Entity\EntAction")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_log_action_id", referencedColumnName="action_id")
     * })
     */
    private $fkLogAction;



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
     * Set logOnline
     *
     * @param \DateTime $logOnline
     *
     * @return EntLog
     */
    public function setLogOnline($logOnline)
    {
        $this->logOnline = $logOnline;

        return $this;
    }

    /**
     * Get logOnline
     *
     * @return \DateTime
     */
    public function getLogOnline()
    {
        return $this->logOnline;
    }

    /**
     * Set logOffline
     *
     * @param \DateTime $logOffline
     *
     * @return EntLog
     */
    public function setLogOffline($logOffline)
    {
        $this->logOffline = $logOffline;

        return $this;
    }

    /**
     * Get logOffline
     *
     * @return \DateTime
     */
    public function getLogOffline()
    {
        return $this->logOffline;
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
     * Set fkLogModule
     *
     * @param \Ent\Entity\EntModule $fkLogModule
     *
     * @return EntLog
     */
    public function setFkLogModule(\Ent\Entity\EntModule $fkLogModule = null)
    {
        $this->fkLogModule = $fkLogModule;

        return $this;
    }

    /**
     * Get fkLogModule
     *
     * @return \Ent\Entity\EntModule
     */
    public function getFkLogModule()
    {
        return $this->fkLogModule;
    }

    /**
     * Set fkLogUser
     *
     * @param \Ent\Entity\EntUser $fkLogUser
     *
     * @return EntLog
     */
    public function setFkLogUser(\Ent\Entity\EntUser $fkLogUser = null)
    {
        $this->fkLogUser = $fkLogUser;

        return $this;
    }

    /**
     * Get fkLogUser
     *
     * @return \Ent\Entity\EntUser
     */
    public function getFkLogUser()
    {
        return $this->fkLogUser;
    }

    /**
     * Set fkLogAction
     *
     * @param \Ent\Entity\EntAction $fkLogAction
     *
     * @return EntLog
     */
    public function setFkLogAction(\Ent\Entity\EntAction $fkLogAction = null)
    {
        $this->fkLogAction = $fkLogAction;

        return $this;
    }

    /**
     * Get fkLogAction
     *
     * @return \Ent\Entity\EntAction
     */
    public function getFkLogAction()
    {
        return $this->fkLogAction;
    }
}
