<?php

namespace Ent\Entity;
use JMS\Serializer\Annotation\MaxDepth;
use JMS\Serializer\Annotation\Groups;

use Doctrine\ORM\Mapping as ORM;

/**
 * EntService
 *
 * @ORM\Table(name="ent_service")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="\Ent\Repository\ServiceRepository")
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
     * @ORM\Column(name="service_name", type="string", length=250, nullable=false, unique=true)
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
     * @ORM\Column(name="service_last_update", type="datetime", nullable=true)
     */
    private $serviceLastUpdate;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Ent\Entity\EntContact", mappedBy="fkCsService")
     * @MaxDepth(1)
     * @Groups({"fkCsContact"})
     */
    private $fkCsContact;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Ent\Entity\EntAttribute", inversedBy="fkSaService",)
     * @ORM\JoinTable(name="ent_service_attribute",
     *   joinColumns={
     *     @ORM\JoinColumn(name="fk_sa_service_id", referencedColumnName="service_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="fk_sa_attribute_id", referencedColumnName="attribute_id")
     *   }
     * )     
     * @Groups({"fkSaAttribute"})
     */
    private $fkSaAttribute = [];

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Ent\Entity\EntProfile", mappedBy="fkPsService")
     * @MaxDepth(1)
     * @Groups({"fkPsProfile"})
     */
    private $fkPsProfile;

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
     * Add contact
     *
     * @param \Ent\Entity\EntContact $contact
     *
     * @return EntContact
     */
    public function addContact($contact)
    {
        $this->fkCsContact[] = $contact;

        return $this;
    }

    /**
     * Add fkCsContact
     *
     * @param \Doctrine\Common\Collections\Collection $fkCsContact
     */
    public function addFkCsContact(\Doctrine\Common\Collections\ArrayCollection $fkCsContact)
    {
        foreach ($fkCsContact as $contact) {
            $this->addContact($contact);
        }
    }

    /**
     * Remove contact
     *
     * @param \Ent\Entity\EntContact $contact
     */
    public function removeContact(\Ent\Entity\EntContact $contact)
    {
        $this->fkCsContact->removeElement($contact);
    }

    /**
     * Remove fkCsContact
     *
     * @param \Doctrine\Common\Collections\Collection $fkCsContact
     */
    public function removeFkCsContact(\Doctrine\Common\Collections\ArrayCollection $fkCsContact)
    {
        foreach ($fkCsContact as $contact) {
            $this->removeContact($contact);
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
     * Add attribute
     *
     * @param EntAttribute $attribute
     *
     * @return EntAttribute
     */
    public function addAttribute($attribute)
    {
        $this->fkSaAttribute[] = $attribute;

        return $this;
    }

    /**
     * Add fkSaAttribute
     *
     * @param \Doctrine\Common\Collections\Collection $fkSaAttribute
     */
    public function addFkSaAttribute(\Doctrine\Common\Collections\ArrayCollection $fkSaAttribute)
    {
        foreach ($fkSaAttribute as $attribute) {
            $this->addAttribute($attribute);
        }
    }

    /**
     * Remove attribute
     *
     * @param \Ent\Entity\EntAttribute $attribute
     */
    public function removeAttribute(\Ent\Entity\EntAttribute $attribute)
    {
        $this->fkSaAttribute->removeElement($attribute);
    }

    /**
     * Remove fkSaAttribute
     *
     * @param \Doctrine\Common\Collections\Collection $fkSaAttribute
     */
    public function removeFkSaAttribute(\Doctrine\Common\Collections\ArrayCollection $fkSaAttribute)
    {
        foreach ($fkSaAttribute as $attribute) {
            $this->removeAttribute($attribute);
        }
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

    /**
     * Add profile
     *
     * @param \Ent\Entity\EntProfile $profile
     *
     * @return EntProfile
     */
    public function addProfile($profile)
    {
        $this->fkPsProfile[] = $profile;

        return $this;
    }

    /**
     * Add fkPsProfile
     *
     * @param \Doctrine\Common\Collections\Collection $fkPsProfile
     */
    public function addFkPsProfile(\Doctrine\Common\Collections\ArrayCollection $fkPsProfile)
    {
        foreach ($fkPsProfile as $profile) {
            $this->addProfile($profile);
        }
    }

    /**
     * Remove profile
     *
     * @param \Ent\Entity\EntProfile $profile
     */
    public function removeProfile(\Ent\Entity\EntProfile $profile)
    {
        $this->fkPsProfile->removeElement($profile);
    }

    /**
     * Remove fkPsProfile
     *
     * @param \Doctrine\Common\Collections\Collection $fkPsProfile
     */
    public function removeFkPsProfile(\Doctrine\Common\Collections\ArrayCollection $fkPsProfile)
    {
        foreach ($fkPsProfile as $profile) {
            $this->removeProfile($profile);
        }
    }

    /**
     * Get fkPsProfile
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFkPsProfile()
    {
        return $this->fkPsProfile;
    }

    /**
     * Now we tell doctrine that before we persist or update we call the updatedTimestamps() function.
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps()
    {
        $this->setServiceLastUpdate(date_create(date('Y-m-d H:i:s'))); //date('Y-m-d H:i:s')  new \DateTime("now")
    }

}
