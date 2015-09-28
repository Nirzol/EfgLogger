<?php

namespace Ent\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EntService
 *
 * @ORM\Table(name="ent_service")
 * @ORM\Entity
 */
class EntService extends Ent
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
    private $serviceLastUpdate;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Ent\Entity\EntContact", mappedBy="fkCsService")
     */
    private $fkCsContact;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Ent\Entity\EntServiceAttribute", mappedBy="fkSaService", cascade={"persist", "remove"}, orphanRemoval=TRUE)
     */
    private $fkSaServiceSA;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkCsContact = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSaServiceSA = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @param \Doctrine\Common\Collections\Collection $fkCsContact
     *
     * @return EntService
     */
    public function addFkCsContact(\Doctrine\Common\Collections\Collection $fkCsContact)
    {
        
        /* @var $contact \Ent\Entity\EntContact */
        foreach($fkCsContact as $contact) {
            if( ! $this->fkCsContact->contains($contact)) {
                $this->fkCsContact->add($contact);
                $contact->addFkCsService(new \Doctrine\Common\Collections\ArrayCollection(array($this)));
            }
        }
    }

    /**
     * Remove fkCsContact
     *
     * @param \Doctrine\Common\Collections\Collection $fkCsContact
     */
    public function removeFkCsContact(\Doctrine\Common\Collections\Collection $fkCsContact)
    {
        /* @var $contact \Ent\Entity\EntContact */
        foreach ($fkCsContact as $contact) {
            $this->fkCsContact->removeElement($contact);
            $contact->removeFkCsService(new \Doctrine\Common\Collections\ArrayCollection(array($this)));
        }
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
     * Add FkSaServiceSA
     *
     * @param \Ent\Entity\EntServiceAttribute fkSaServiceSA
     *
     * @return EntService
     */
    public function addFkSaServiceSA(\Ent\Entity\EntServiceAttribute $fkSaServiceSA)
    {
        if (!$this->fkSaServiceSA->contains($fkSaServiceSA)) {
            $this->fkSaServiceSA->add($fkSaServiceSA);
            $fkSaServiceSA->setFkSaService($this);
        }
        return $this;
    }
//    public function addFkSaServiceSA(\Doctrine\Common\Collections\Collection $fkSaServiceSA)
//    {
//        /* @var $role \Ent\Entity\EntServiceAttribute */
//        foreach ($fkSaServiceSA as $sa) {
//            if (!$this->fkSaServiceSA->contains($sa)) {
//                $this->fkSaServiceSA->add($sa);
//                $sa->setFkSaService($this);
//            }
//        }
//        return $this;
//    }

    /**
     * Remove FkSaServiceSA
     *
     * @param \Ent\Entity\EntServiceAttribute $fkSaServiceSA
     */
    public function removeFkSaService(\Ent\Entity\EntServiceAttribute $fkSaServiceSA)
    {
        if ($this->fkSaServiceSA->contains($fkSaServiceSA)) {
            $this->fkSaServiceSA->removeElement($fkSaServiceSA);
            $fkSaServiceSA->setFkSaService(null);
        }
        return $this;
    }
//    public function removeFkSaService(\Doctrine\Common\Collections\Collection $fkSaServiceSA)
//    {
//        /* @var $sa \Ent\Entity\EntServiceAttribute */
//        foreach ($fkSaServiceSA as $sa) {
//            $this->fkSaServiceSA->removeElement($sa);
//            $sa->setFkSaService(null);
//        }
//        return $this;
//    }
    
    /**
     * Get FkSaServiceSA
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFkSaService() {
        return $this->fkSaService->toArray();
    }
    
    /**
     * Get attribute
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAttributes() {
        return array_map(
            function ($fkSaServiceSA) {
                return array('attribute' => $fkSaServiceSA->getFkSaAttribute(), 'value' => $fkSaServiceSA->getServiceAttributeValue());
            },
            $this->fkSaServiceSA->toArray()
        );
    }
    
}
