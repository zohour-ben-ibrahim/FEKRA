<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * invitation
 *
 * @ORM\Table(name="invitation")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\invitationRepository")
 */
class invitation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     */
    private $follower;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     */
    private $following;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="invitDate", type="datetime")
     */
    private $invitDate;


    /**
     * @var bool
     *
     * @ORM\Column(name="status", type="boolean")
     */

    public function getId()
    {
        return $this->id;
    }

    /**
     * Set invitDate
     *
     * @param \DateTime $invitDate
     *
     * @return invitation
     */
    public function setInvitDate($invitDate)
    {
        $this->invitDate = $invitDate;

        return $this;
    }

    /**
     * Get invitDate
     *
     * @return \DateTime
     */
    public function getInvitDate()
    {
        return $this->invitDate;
    }


    /**
     * Set follower
     *
     * @param \AppBundle\Entity\User $follower
     *
     * @return invitation
     */
    public function setFollower(\AppBundle\Entity\User $follower = null)
    {
        $this->follower = $follower;

        return $this;
    }

    /**
     * Get follower
     *
     * @return \AppBundle\Entity\User
     */
    public function getFollower()
    {
        return $this->follower;
    }


    /**
     * Set following
     *
     * @param \AppBundle\Entity\User $following
     *
     * @return invitation
     */
    public function setFollowing(\AppBundle\Entity\User $following = null)
    {
        $this->following = $following;

        return $this;
    }

    /**
     * Get following
     *
     * @return \AppBundle\Entity\User
     */
    public function getFollowing()
    {
        return $this->following;
    }
}
