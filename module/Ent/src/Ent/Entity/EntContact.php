<?php

namespace Ent\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EntContact
 *
 * @ORM\Table(name="ent_contact", indexes={@ORM\Index(name="fk_structure_id", columns={"fk_contact_structure_id"})})
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity
 */
class EntContact extends Ent
{

    /**
     * @var integer
     *
     * @ORM\Column(name="contact_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $contactId;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_name", type="string", length=200, nullable=false)
     */
    private $contactName;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_libelle", type="string", length=200, nullable=false)
     */
    private $contactLibelle;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_description", type="text", nullable=false)
     */
    private $contactDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_service", type="string", length=200, nullable=false)
     */
    private $contactService;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_mailto", type="string", length=254, nullable=false)
     */
    private $contactMailto;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="contact_last_update", type="datetime", nullable=true)
     */
    private $contactLastUpdate;

    /**
     * @var \Ent\Entity\EntStructure
     *
     * @ORM\ManyToOne(targetEntity="Ent\Entity\EntStructure")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_contact_structure_id", referencedColumnName="structure_id")
     * })
     */
    private $fkContactStructure;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Ent\Entity\EntService", inversedBy="fkCsContact")
     * @ORM\JoinTable(name="ent_contact_service",
     *   joinColumns={
     *     @ORM\JoinColumn(name="fk_cs_contact_id", referencedColumnName="contact_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="fk_cs_service_id", referencedColumnName="service_id")
     *   }
     * )
     */
    private $fkCsService;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Ent\Entity\EntUser", inversedBy="fkUcContact")
     * @ORM\JoinTable(name="ent_user_contact",
     *   joinColumns={
     *     @ORM\JoinColumn(name="fk_uc_contact_id", referencedColumnName="contact_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="fk_uc_user_id", referencedColumnName="user_id")
     *   }
     * )
     */ 
    private $fkUcUser;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkCsService = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkUcUser = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get contactId
     *
     * @return integer
     */
    public function getContactId()
    {
        return $this->contactId;
    }

    /**
     * Set contactName
     *
     * @param string $contactName
     *
     * @return EntContact
     */
    public function setContactName($contactName)
    {
        $this->contactName = $contactName;

        return $this;
    }

    /**
     * Get contactName
     *
     * @return string
     */
    public function getContactName()
    {
        return $this->contactName;
    }

    /**
     * Set contactLibelle
     *
     * @param string $contactLibelle
     *
     * @return EntContact
     */
    public function setContactLibelle($contactLibelle)
    {
        $this->contactLibelle = $contactLibelle;

        return $this;
    }

    /**
     * Get contactLibelle
     *
     * @return string
     */
    public function getContactLibelle()
    {
        return $this->contactLibelle;
    }

    /**
     * Set contactDescription
     *
     * @param string $contactDescription
     *
     * @return EntContact
     */
    public function setContactDescription($contactDescription)
    {
        $this->contactDescription = $contactDescription;

        return $this;
    }

    /**
     * Get contactDescription
     *
     * @return string
     */
    public function getContactDescription()
    {
        return $this->contactDescription;
    }

    /**
     * Set contactService
     *
     * @param string $contactService
     *
     * @return EntContact
     */
    public function setContactService($contactService)
    {
        $this->contactService = $contactService;

        return $this;
    }

    /**
     * Get contactService
     *
     * @return string
     */
    public function getContactService()
    {
        return $this->contactService;
    }

    /**
     * Set contactMailto
     *
     * @param string $contactMailto
     *
     * @return EntContact
     */
    public function setContactMailto($contactMailto)
    {
        $this->contactMailto = $contactMailto;

        return $this;
    }

    /**
     * Get contactMailto
     *
     * @return string
     */
    public function getContactMailto()
    {
        return $this->contactMailto;
    }

    /**
     * Set contactLastUpdate
     *
     * @param \DateTime $contactLastUpdate
     *
     * @return EntContact
     */
    public function setContactLastUpdate($contactLastUpdate)
    {
        $this->contactLastUpdate = $contactLastUpdate;

        return $this;
    }

    /**
     * Get contactLastUpdate
     *
     * @return \DateTime
     */
    public function getContactLastUpdate()
    {
        return $this->contactLastUpdate;
    }

    /**
     * Set fkContactStructure
     *
     * @param \Ent\Entity\EntStructure $fkContactStructure
     *
     * @return EntContact
     */
    public function setFkContactStructure(\Ent\Entity\EntStructure $fkContactStructure = null)
    {
        $this->fkContactStructure = $fkContactStructure;

        return $this;
    }

    /**
     * Get fkContactStructure
     *
     * @return \Ent\Entity\EntStructure
     */
    public function getFkContactStructure()
    {
        return $this->fkContactStructure;
    }

    /**
     * Add service
     *
     * @param EntService $service
     *
     * @return EntService
     */
    public function addService($service)
    {
        $this->fkCsService[] = $service;

        return $this;
    }

    /**
     * Add fkCsService
     *
     * @param \Doctrine\Common\Collections\Collection $fkCsService
     */
    public function addFkCsService(\Doctrine\Common\Collections\ArrayCollection $fkCsService)
    {
        foreach ($fkCsService as $service) {
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
        $this->fkCsService->removeElement($service);
    }

    /**
     * Remove fkCsService
     *
     * @param \Doctrine\Common\Collections\Collection $fkCsService
     */
    public function removeFkCsService(\Doctrine\Common\Collections\ArrayCollection $fkCsService)
    {
        foreach ($fkCsService as $service) {
            $this->removeService($service);
        }
    }

    /**
     * Get fkCsService
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFkCsService()
    {
        return $this->fkCsService;
    }

    /**
     * Add user
     *
     * @param \Ent\Entity\EntUser $user
     *
     * @return EntUser
     */
    public function addUser($user)
    {
        $this->fkUcUser[] = $user;

        return $this;
    }

    /**
     * Add fkUcUser
     *
     * @param \Doctrine\Common\Collections\Collection $fkUcUser
     *
     */
    public function addFkUcUser(\Doctrine\Common\Collections\ArrayCollection $fkUcUser)
    {
        foreach ($fkUcUser as $user) {
            $this->addUser($user);
        }
    }

    /**
     * Remove user
     *
     * @param \Ent\Entity\EntUser $user
     */
    public function removeUser(\Ent\Entity\EntUser $user)
    {
        $this->fkUcUser->removeElement($user);
    }

    /**
     * Remove fkUcUser
     *
     * @param \Doctrine\Common\Collections\Collection $fkUcUser
     */
    public function removeFkUcUser(\Doctrine\Common\Collections\ArrayCollection $fkUcUser)
    {
        foreach ($fkUcUser as $user) {
            $this->removeUser($user);
        }
    }

    /**
     * Get fkUcUser
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFkUcUser()
    {
        return $this->fkUcUser;
    }

    /**
     * Now we tell doctrine that before we persist or update we call the updatedTimestamps() function.
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps()
    {
        $this->setContactLastUpdate(date_create(date('Y-m-d H:i:s'))); //date('Y-m-d H:i:s')  new \DateTime("now")
    }

}
