<?php

namespace Ent\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EntModule
 *
 * @ORM\Table(name="ent_module")
 * @ORM\Entity
 */
class EntModule extends Ent
{
    /**
     * @var integer
     *
     * @ORM\Column(name="module_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $moduleId;

    /**
     * @var string
     *
     * @ORM\Column(name="module_name", type="string", length=250, nullable=false)
     */
    private $moduleName;

    /**
     * @var string
     *
     * @ORM\Column(name="module_libelle", type="string", length=250, nullable=true)
     */
    private $moduleLibelle;

    /**
     * @var string
     *
     * @ORM\Column(name="module_description", type="text", nullable=true)
     */
    private $moduleDescription;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="module_last_update", type="datetime", nullable=true)
     */
    private $moduleLastUpdate;



    /**
     * Get moduleId
     *
     * @return integer
     */
    public function getModuleId()
    {
        return $this->moduleId;
    }
    
    public function setModuleId($id) {
        $this->moduleId = $id;
        return $this;
    }

    /**
     * Set moduleName
     *
     * @param string $moduleName
     *
     * @return EntModule
     */
    public function setModuleName($moduleName)
    {
        $this->moduleName = $moduleName;

        return $this;
    }

    /**
     * Get moduleName
     *
     * @return string
     */
    public function getModuleName()
    {
        return $this->moduleName;
    }

    /**
     * Set moduleLibelle
     *
     * @param string $moduleLibelle
     *
     * @return EntModule
     */
    public function setModuleLibelle($moduleLibelle)
    {
        $this->moduleLibelle = $moduleLibelle;

        return $this;
    }

    /**
     * Get moduleLibelle
     *
     * @return string
     */
    public function getModuleLibelle()
    {
        return $this->moduleLibelle;
    }

    /**
     * Set moduleDescription
     *
     * @param string $moduleDescription
     *
     * @return EntModule
     */
    public function setModuleDescription($moduleDescription)
    {
        $this->moduleDescription = $moduleDescription;

        return $this;
    }

    /**
     * Get moduleDescription
     *
     * @return string
     */
    public function getModuleDescription()
    {
        return $this->moduleDescription;
    }

    /**
     * Set moduleLastUpdate
     *
     * @param \DateTime $moduleLastUpdate
     *
     * @return EntModule
     */
    public function setModuleLastUpdate($moduleLastUpdate)
    {
        $this->moduleLastUpdate = $moduleLastUpdate;

        return $this;
    }

    /**
     * Get moduleLastUpdate
     *
     * @return \DateTime
     */
    public function getModuleLastUpdate()
    {
        return $this->moduleLastUpdate;
    }
}
