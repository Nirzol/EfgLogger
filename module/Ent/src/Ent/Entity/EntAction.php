<?php

namespace Ent\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EntAction
 *
 * @ORM\Table(name="ent_action")
 * @ORM\Entity
 */
class EntAction extends Ent
{
    /**
     * @var integer
     *
     * @ORM\Column(name="action_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $actionId;

    /**
     * @var string
     *
     * @ORM\Column(name="action_name", type="string", length=250, nullable=false)
     */
    private $actionName;

    /**
     * @var string
     *
     * @ORM\Column(name="action_libelle", type="string", length=250, nullable=true)
     */
    private $actionLibelle;

    /**
     * @var string
     *
     * @ORM\Column(name="action_description", type="text", nullable=true)
     */
    private $actionDescription;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="action_last_update", type="datetime", nullable=true)
     */
    private $actionLastUpdate;



    /**
     * Get actionId
     *
     * @return integer
     */
    public function getActionId()
    {
        return $this->actionId;
    }

    /**
     * Set actionName
     *
     * @param string $actionName
     *
     * @return EntAction
     */
    public function setActionName($actionName)
    {
        $this->actionName = $actionName;

        return $this;
    }

    /**
     * Get actionName
     *
     * @return string
     */
    public function getActionName()
    {
        return $this->actionName;
    }

    /**
     * Set actionLibelle
     *
     * @param string $actionLibelle
     *
     * @return EntAction
     */
    public function setActionLibelle($actionLibelle)
    {
        $this->actionLibelle = $actionLibelle;

        return $this;
    }

    /**
     * Get actionLibelle
     *
     * @return string
     */
    public function getActionLibelle()
    {
        return $this->actionLibelle;
    }

    /**
     * Set actionDescription
     *
     * @param string $actionDescription
     *
     * @return EntAction
     */
    public function setActionDescription($actionDescription)
    {
        $this->actionDescription = $actionDescription;

        return $this;
    }

    /**
     * Get actionDescription
     *
     * @return string
     */
    public function getActionDescription()
    {
        return $this->actionDescription;
    }

    /**
     * Set actionLastUpdate
     *
     * @param \DateTime $actionLastUpdate
     *
     * @return EntAction
     */
    public function setActionLastUpdate($actionLastUpdate)
    {
        $this->actionLastUpdate = $actionLastUpdate;

        return $this;
    }

    /**
     * Get actionLastUpdate
     *
     * @return \DateTime
     */
    public function getActionLastUpdate()
    {
        return $this->actionLastUpdate;
    }
}
