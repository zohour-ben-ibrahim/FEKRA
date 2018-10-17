<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * idea
 *
 * @ORM\Table(name="idea")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ideaRepository")
 */
class idea
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
    private $IdUser;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\categorie")
     */
    private $categorie;

    /**
     * @var string
     * @Assert\NotBlank(message="Champ obligatoire")
     * @ORM\Column(name="title", type="string", length=200)
     */

    private $title;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="addDate", type="datetime")
     */
    private $addDate;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="string", length=800)
     */
    private $content;

    /**
     * @var int
     *
     * @ORM\Column(name="visibility", type="integer")
     */
    private $visibility;

    /**
     * @var bool
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="attachmentPath", type="string", length=400, nullable=true)
     */
    private $attachmentPath;


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
     * Set title
     *
     * @param string $title
     *
     * @return idea
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set addDate
     *
     * @param \DateTime $addDate
     *
     * @return idea
     */
    public function setAddDate($addDate)
    {
        $this->addDate = $addDate;

        return $this;
    }

    /**
     * Get addDate
     *
     * @return \DateTime
     */
    public function getAddDate()
    {
        return $this->addDate;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return idea
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set visibility
     *
     * @param integer $visibility
     *
     * @return idea
     */
    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;

        return $this;
    }

    /**
     * Get visibility
     *
     * @return int
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * Set status
     *
     * @param boolean $status
     *
     * @return idea
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return bool
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set attachmentPath
     *
     * @param string $attachmentPath
     *
     * @return idea
     */
    public function setAttachmentPath($attachmentPath)
    {
        $this->attachmentPath = $attachmentPath;

        return $this;
    }

    /**
     * Get attachmentPath
     *
     * @return string
     */
    public function getAttachmentPath()
    {
        return $this->attachmentPath;
    }

    /**
     * Set idUser
     *
     * @param \AppBundle\Entity\User $idUser
     *
     * @return idea
     */
    public function setIdUser(\AppBundle\Entity\User $idUser = null)
    {
        $this->IdUser = $idUser;

        return $this;
    }

    /**
     * Get idUser
     *
     * @return \AppBundle\Entity\User
     */
    public function getIdUser()
    {
        return $this->IdUser;
    }

    /**
     * Set categorie
     *
     * @param \AppBundle\Entity\categorie $categorie
     *
     * @return idea
     */
    public function setCategorie(\AppBundle\Entity\categorie $categorie = null)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return \AppBundle\Entity\categorie
     */
    public function getCategorie()
    {
        return $this->categorie;
    }
    public function compareDates(){
        $datetime1 = $this->addDate;
        $datetime2 = date_create(date('Y-m-d H:i:s',time()));
        $interval = $datetime1->diff($datetime2);
        if($interval->y){
            return $interval->y.' years Ago';
        } elseif($interval->m){
            return $interval->m.' months Ago';
        }elseif($interval->d){
            return $interval->d.' days Ago';
        }elseif($interval->h){
            return $interval->h.' hours Ago';
        }elseif($interval->i){
            return $interval->i.' minutes Ago';
        }else
        {
            return "à l'instant";
        }
    }
    public function getIdea()
    {
        return $this;
    }
    public function __toString() {
        return $this->getTitle();
    }
}
