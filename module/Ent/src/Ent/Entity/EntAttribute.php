<?php

namespace Ent\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EntAttribute
 *
 * @ORM\Table(name="ent_attribute")
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
     * @ORM\Column(name="attribute_name", type="string", length=250, nullable=false)
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
     * @ORM\OneToMany(targetEntity="Ent\Entity\EntServiceAttribute", mappedBy="fkSaAttribute", cascade={"persist", "remove"}, orphanRemoval=TRUE)
     */
    private $fkSaAttributeSA;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkSaAttributeSA = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add FkSaAttributeSA
     *
     * @param \Doctrine\Common\Collections\Collection $fkSaAttributeSA
     *
     * @return EntAttribute
     */
    public function addFkSaAttributeSA(\Ent\Entity\EntServiceAttribute $fkSaAttributeSA)
    {
        if (!$this->fkSaAttributeSA->contains($fkSaAttributeSA)) {
            $this->fkSaAttributeSA->add($fkSaAttributeSA);
            $fkSaAttributeSA->setFkSaAttribute($this);
        }
        return $this;
    }
//    public function addFkSaAttributeSA(\Doctrine\Common\Collections\Collection $fkSaAttributeSA)
//    {
//        /* @var $role \Ent\Entity\EntServiceAttribute */
//        foreach ($fkSaAttributeSA as $sa) {
//            if (!$this->fkSaAttributeSA->contains($sa)) {
//                $this->fkSaAttributeSA->add($sa);
//                $sa->setFkSaAttribute($this);
//            }
//        }
//        return $this;
//    }

    /**
     * Remove FkSaAttributeSA
     *
     * @param \Doctrine\Common\Collections\Collection $fkSaAttributeSA
     */
    public function removeFkSaAttributeSA(\Ent\Entity\EntServiceAttribute $fkSaAttributeSA)
    {
        if ($this->fkSaAttributeSA->contains($fkSaAttributeSA)) {
            $this->fkSaAttributeSA->removeElement($fkSaAttributeSA);
            $fkSaAttributeSA->setFkSaAttribute(null);
        }
        return $this;
    }
//    public function removeFkSaAttributeSA(\Doctrine\Common\Collections\Collection $fkSaAttributeSA)
//    {
//        /* @var $role \Ent\Entity\EntServiceAttribute */
//        foreach ($fkSaAttributeSA as $sa) {
//            $this->fkSaAttributeSA->removeElement($sa);
//            $sa->setFkSaAttribute(null);
//        }
//        return $this;
//    }
    
    /**
     * Get FkSaAttributeSA
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    function getFkSaAttributeSA() {
        return $this->fkSaAttributeSA->toArray();
    }
    
}
