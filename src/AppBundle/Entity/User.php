<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use FOS\MessageBundle\Model\ParticipantInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser implements ParticipantInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var bool
     *
     * @ORM\Column(name="profileVisibility", type="boolean")
     */
    private $profileVisibility;


    /**
     * Set profileVisibility
     *
     * @param boolean $profileVisibility
     *
     * @return User
     */
    public function setProfileVisibility($profileVisibility)
    {
        $this->profileVisibility = $profileVisibility;

        return $this;
    }

    public function __construct($visibility=true)
    {
        parent::__construct();
        // your own logic
        $this->profileVisibility=$visibility;
    }


    /**
     * Get profileVisibility
     *
     * @return bool
     */
    public function getProfileVisibility()
    {
        return $this->profileVisibility;
    }


}
