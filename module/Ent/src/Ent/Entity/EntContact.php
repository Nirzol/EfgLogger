<?php

namespace Ent\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EntContact
 *
 * @ORM\Table(name="ent_contact", indexes={@ORM\Index(name="fk_structure_id", columns={"fk_contact_structure_id"})})
 * @ORM\Entity
 */
class EntContact
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
     * @ORM\Column(name="contact_last_update", type="datetime", nullable=false)
     */
    private $contactLastUpdate = 'CURRENT_TIMESTAMP';

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
     * @ORM\ManyToMany(targetEntity="Ent\Entity\EntUser", mappedBy="fkUcContact")
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
     * Add fkCsService
     *
     * @param \Ent\Entity\EntService $fkCsService
     *
     * @return EntContact
     */
    public function addFkCsService(\Ent\Entity\EntService $fkCsService)
    {
        $this->fkCsService[] = $fkCsService;

        return $this;
    }

    /**
     * Remove fkCsService
     *
     * @param \Ent\Entity\EntService $fkCsService
     */
    public function removeFkCsService(\Ent\Entity\EntService $fkCsService)
    {
        $this->fkCsService->removeElement($fkCsService);
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
     * Add fkUcUser
     *
     * @param \Ent\Entity\EntUser $fkUcUser
     *
     * @return EntContact
     */
    public function addFkUcUser(\Ent\Entity\EntUser $fkUcUser)
    {
        $this->fkUcUser[] = $fkUcUser;

        return $this;
    }

    /**
     * Remove fkUcUser
     *
     * @param \Ent\Entity\EntUser $fkUcUser
     */
    public function removeFkUcUser(\Ent\Entity\EntUser $fkUcUser)
    {
        $this->fkUcUser->removeElement($fkUcUser);
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
}
