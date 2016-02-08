<?php

namespace Ent\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\MaxDepth;
use JMS\Serializer\Annotation\Groups;

/**
 * EntAttribute
 *
 * @ORM\Table(name="ent_attribute")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity
 */
class EntAttribute extends Ent
{

    /**
     * @var integer
     *
     * @ORM\Column(name="attribute_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $attributeId;

    /**
     * @var string
     *
     * @ORM\Column(name="attribute_name", type="string", length=250, nullable=false, unique=true)
     */
    private $attributeName;

    /**
     * @var string
     *
     * @ORM\Column(name="attribute_libelle", type="string", length=250, nullable=true)
     */
    private $attributeLibelle;

    /**
     * @var string
     *
     * @ORM\Column(name="attribute_description", type="text", nullable=true)
     */
    private $attributeDescription;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="attribute_last_update", type="datetime", nullable=true)
     */
    private $attributeLastUpdate;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Ent\Entity\EntService", mappedBy="fkSaAttribute")
     * @MaxDepth(1)
     * @Groups({"fkSaService"})
     */
    private $fkSaService;

    /**
     * @var \Ent\Entity\EntListtype
     *
     * @ORM\ManyToOne(targetEntity="Ent\Entity\EntListtype")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_attribute_listtype_id", referencedColumnName="listtype_id")
     * })
     */
    private $fkAttributeListtype;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkSaService = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get attributeId
     *
     * @return integer
     */
    public function getAttributeId()
    {
        return $this->attributeId;
    }

    /**
     * Set attributeName
     *
     * @param string $attributeName
     *
     * @return EntAttribute
     */
    public function setAttributeName($attributeName)
    {
        $this->attributeName = $attributeName;

        return $this;
    }

    /**
     * Get attributeName
     *
     * @return string
     */
    public function getAttributeName()
    {
        return $this->attributeName;
    }

    /**
     * Set attributeLibelle
     *
     * @param string $attributeLibelle
     *
     * @return EntAttribute
     */
    public function setAttributeLibelle($attributeLibelle)
    {
        $this->attributeLibelle = $attributeLibelle;

        return $this;
    }

    /**
     * Get attributeLibelle
     *
     * @return string
     */
    public function getAttributeLibelle()
    {
        return $this->attributeLibelle;
    }

    /**
     * Set attributeDescription
     *
     * @param string $attributeDescription
     *
     * @return EntAttribute
     */
    public function setAttributeDescription($attributeDescription)
    {
        $this->attributeDescription = $attributeDescription;

        return $this;
    }

    /**
     * Get attributeDescription
     *
     * @return string
     */
    public function getAttributeDescription()
    {
        return $this->attributeDescription;
    }

    /**
     * Set attributeLastUpdate
     *
     * @param \DateTime $attributeLastUpdate
     *
     * @return EntAttribute
     */
    public function setAttributeLastUpdate($attributeLastUpdate)
    {
        $this->attributeLastUpdate = $attributeLastUpdate;

        return $this;
    }

    /**
     * Get attributeLastUpdate
     *
     * @return \DateTime
     */
    public function getAttributeLastUpdate()
    {
        return $this->attributeLastUpdate;
    }

    /**
     * Add service
     *
     * @param \Ent\Entity\EntService $service
     *
     * @return EntService
     */
    public function addService($service)
    {
        $this->fkSaService[] = $service;

        return $this;
    }

    /**
     * Add fkSaService
     *
     * @param \Doctrine\Common\Collections\Collection $fkSaService
     */
    public function addFkSaService(\Doctrine\Common\Collections\ArrayCollection $fkSaService)
    {
        foreach ($fkSaService as $service) {
            $this->addService($service);
        }
    }

    /**
     * Remove service
     *
     * @param \Ent\Entity\EntService $service
     */
    public function removeService(\Ent\Entity\EntService $service)
    {
        $this->fkSaService->removeElement($service);
    }

    /**
     * Remove fkSaService
     *
     * @param \Doctrine\Common\Collections\Collection $fkSaService
     */
    public function removeFkSaService(\Doctrine\Common\Collections\ArrayCollection $fkSaService)
    {
        foreach ($fkSaService as $service) {
            $this->removeService($service);
        }
    }

    /**
     * Get fkSaService
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFkSaService()
    {
        return $this->fkSaService;
    }

    /**
     * Set fkAttributeListtype
     *
     * @param \Ent\Entity\EntList $fkAttributeListtype
     *
     * @return EntAttribute
     */
    public function setFkAttributeListtype(\Ent\Entity\EntList $fkAttributeListtype = null)
    {
        $this->fkAttributeListtype = $fkAttributeListtype;

        return $this;
    }

    /**
     * Get fkAttributeListtype
     *
     * @return \Ent\Entity\EntList
     */
    public function getFkAttributeListtype()
    {
        return $this->fkAttributeListtype;
    }

    /**
     * Now we tell doctrine that before we persist or update we call the updatedTimestamps() function.
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps()
    {
        $this->setAttributeLastUpdate(date_create(date('Y-m-d H:i:s'))); //date('Y-m-d H:i:s')  new \DateTime("now")
    }

}
