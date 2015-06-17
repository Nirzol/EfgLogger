<?php

namespace Ent\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EntService
 *
 * @ORM\Table(name="ent_service")
 * @ORM\Entity
 */
class EntService
{
    /**
     * @var integer
     *
     * @ORM\Column(name="service_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $serviceId;

    /**
     * @var string
     *
     * @ORM\Column(name="service_name", type="string", length=250, nullable=false)
     */
    private $serviceName;

    /**
     * @var string
     *
     * @ORM\Column(name="service_libelle", type="string", length=250, nullable=true)
     */
    private $serviceLibelle;

    /**
     * @var string
     *
     * @ORM\Column(name="service_description", type="text", nullable=true)
     */
    private $serviceDescription;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="service_last_update", type="datetime", nullable=false)
     */
    private $serviceLastUpdate = 'CURRENT_TIMESTAMP';

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Ent\Entity\EntContact", mappedBy="fkCsService")
     */
    private $fkCsContact;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Ent\Entity\EntAttribute", inversedBy="fkSaService")
     * @ORM\JoinTable(name="ent_service_attribute",
     *   joinColumns={
     *     @ORM\JoinColumn(name="fk_sa_service_id", referencedColumnName="service_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="fk_sa_attribute_id", referencedColumnName="attribute_id")
     *   }
     * )
     */
    private $fkSaAttribute;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkCsContact = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSaAttribute = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Get serviceId
     *
     * @return integer
     */
    public function getServiceId()
    {
        return $this->serviceId;
    }

    /**
     * Set serviceName
     *
     * @param string $serviceName
     *
     * @return EntService
     */
    public function setServiceName($serviceName)
    {
        $this->serviceName = $serviceName;

        return $this;
    }

    /**
     * Get serviceName
     *
     * @return string
     */
    public function getServiceName()
    {
        return $this->serviceName;
    }

    /**
     * Set serviceLibelle
     *
     * @param string $serviceLibelle
     *
     * @return EntService
     */
    public function setServiceLibelle($serviceLibelle)
    {
        $this->serviceLibelle = $serviceLibelle;

        return $this;
    }

    /**
     * Get serviceLibelle
     *
     * @return string
     */
    public function getServiceLibelle()
    {
        return $this->serviceLibelle;
    }

    /**
     * Set serviceDescription
     *
     * @param string $serviceDescription
     *
     * @return EntService
     */
    public function setServiceDescription($serviceDescription)
    {
        $this->serviceDescription = $serviceDescription;

        return $this;
    }

    /**
     * Get serviceDescription
     *
     * @return string
     */
    public function getServiceDescription()
    {
        return $this->serviceDescription;
    }

    /**
     * Set serviceLastUpdate
     *
     * @param \DateTime $serviceLastUpdate
     *
     * @return EntService
     */
    public function setServiceLastUpdate($serviceLastUpdate)
    {
        $this->serviceLastUpdate = $serviceLastUpdate;

        return $this;
    }

    /**
     * Get serviceLastUpdate
     *
     * @return \DateTime
     */
    public function getServiceLastUpdate()
    {
        return $this->serviceLastUpdate;
    }

    /**
     * Add fkCsContact
     *
     * @param \Ent\Entity\EntContact $fkCsContact
     *
     * @return EntService
     */
    public function addFkCsContact(\Ent\Entity\EntContact $fkCsContact)
    {
        $this->fkCsContact[] = $fkCsContact;

        return $this;
    }

    /**
     * Remove fkCsContact
     *
     * @param \Ent\Entity\EntContact $fkCsContact
     */
    public function removeFkCsContact(\Ent\Entity\EntContact $fkCsContact)
    {
        $this->fkCsContact->removeElement($fkCsContact);
    }

    /**
     * Get fkCsContact
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFkCsContact()
    {
        return $this->fkCsContact;
    }

    /**
     * Add fkSaAttribute
     *
     * @param \Ent\Entity\EntAttribute $fkSaAttribute
     *
     * @return EntService
     */
    public function addFkSaAttribute(\Ent\Entity\EntAttribute $fkSaAttribute)
    {
        $this->fkSaAttribute[] = $fkSaAttribute;

        return $this;
    }

    /**
     * Remove fkSaAttribute
     *
     * @param \Ent\Entity\EntAttribute $fkSaAttribute
     */
    public function removeFkSaAttribute(\Ent\Entity\EntAttribute $fkSaAttribute)
    {
        $this->fkSaAttribute->removeElement($fkSaAttribute);
    }

    /**
     * Get fkSaAttribute
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFkSaAttribute()
    {
        return $this->fkSaAttribute;
    }
}
