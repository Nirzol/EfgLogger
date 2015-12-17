<?php

namespace Ent\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\MaxDepth;
use JMS\Serializer\Annotation\Groups;

/**
 * EntLove
 *
 * @ORM\Table(name="ent_love", uniqueConstraints={@ORM\UniqueConstraint(name="love", columns={"love_love"})})
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity
 */
class EntLove extends Ent
{

    /**
     * @var integer
     *
     * @ORM\Column(name="love_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $loveId;

    /**
     * @var string
     *
     * @ORM\Column(name="love_love", type="string", length=250, nullable=false, unique=true)
     */
    private $loveLove;

    /**
     * @var boolean
     *
     * @ORM\Column(name="love_status", type="boolean", nullable=false)
     */
    private $loveStatus = '1';

    /**
     * Set loveId
     *
     * @param int $loveId
     *
     * @return EntLove
     */
    public function setLoveId($loveId)
    {
        $this->loveId = $loveId;

        return $this;
    }

    /**
     * Get loveId
     *
     * @return integer
     */
    public function getLoveId()
    {
        return $this->loveId;
    }

    /**
     * Set loveLove
     *
     * @param string $loveLove
     *
     * @return EntLove
     */
    public function setLoveLove($loveLove)
    {
        $this->loveLove = $loveLove;

        return $this;
    }

    /**
     * Get loveLove
     *
     * @return string
     */
    public function getLoveLove()
    {
        return $this->loveLove;
    }

    /**
     * Set loveStatus
     *
     * @param boolean $loveStatus
     *
     * @return EntLove
     */
    public function setLoveStatus($loveStatus)
    {
        $this->loveStatus = $loveStatus;

        return $this;
    }

    /**
     * Get loveStatus
     *
     * @return boolean
     */
    public function getLoveStatus()
    {
        return $this->loveStatus;
    }

}
