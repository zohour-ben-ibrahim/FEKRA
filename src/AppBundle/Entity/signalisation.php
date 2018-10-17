<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * signalisation
 *
 * @ORM\Table(name="signalisation")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\signalisationRepository")
 */
class signalisation
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
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     */
    private $compteSignale;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\idea")
     */
    private $ideaSignale;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="signalDate", type="datetime")
     */
    private $signalDate;

    /**
     * @var string
     *
     * @ORM\Column(name="motif", type="string", length=200)
     */
    private $motif;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="string", length=300)
     */
    private $comment;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set signalDate
     *
     * @param \DateTime $signalDate
     *
     * @return signalisation
     */
    public function setSignalDate($signalDate)
    {
        $this->signalDate = $signalDate;

        return $this;
    }

    /**
     * Get signalDate
     *
     * @return \DateTime
     */
    public function getSignalDate()
    {
        return $this->signalDate;
    }

    /**
     * Set motif
     *
     * @param string $motif
     *
     * @return signalisation
     */
    public function setMotif($motif)
    {
        $this->motif = $motif;

        return $this;
    }

    /**
     * Get motif
     *
     * @return string
     */
    public function getMotif()
    {
        return $this->motif;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return signalisation
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }
}

