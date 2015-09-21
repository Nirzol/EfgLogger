<?php

namespace Ent\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EntServiceAttribute
 *
 * @ORM\Table(name="ent_service_attribute")
 * @ORM\Entity
 */
class EntServiceAttribute extends Ent
{
    /**
     * @var integer
     *
     * @ORM\Column(name="service_attribute_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $serviceAttributeId;
    
    /**
     * @var \Ent\Entity\EntService
     *
     * @ORM\ManyToOne(targetEntity="Ent\Entity\EntService")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_sa_service_id", referencedColumnName="service_id")
     * })
     */
    private $fkSaService;
    
     /**
     * @var \Ent\Entity\EntAttribute
     *
     * @ORM\ManyToOne(targetEntity="Ent\Entity\EntAttribute")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_sa_attribute_id", referencedColumnName="attribute_id")
     * })
     */
    private $fkSaAttribute;
    
    /**
     * @var string
     *
     * @ORM\Column(name="sa_value", type="text", nullable=false)
     */
    private $serviceAttributeValue;
    
    function getServiceAttributeId() {
        return $this->serviceAttributeId;
    }
    
    function setServiceAttributeId($serviceAttributeId) {
        $this->serviceAttributeId = $serviceAttributeId;
        
        return $this;
    }

    function getFkSaService() {
        return $this->fkSaService;
    }
    
    function setFkSaService(\Ent\Entity\EntService $fkSaService) {
        $this->fkSaService = $fkSaService;
        
        return $this;
    }

    function getFkSaAttribute() {
        return $this->fkSaAttribute;
    }
    
    function setFkSaAttribute(\Ent\Entity\EntAttribute $fkSaAttribute) {
        $this->fkSaAttribute = $fkSaAttribute;
        
        return $this;
    }

    function getServiceAttributeValue() {
        return $this->serviceAttributeValue;
    }

    function setServiceAttributeValue($serviceAttributeValue) {
        $this->serviceAttributeValue = $serviceAttributeValue;
        
        return $this;
    }
}
