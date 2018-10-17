<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * comment
 *
 * @ORM\Table(name="comment")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\commentRepository")
 */
class comment
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
    private $User;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\idea",
     *       cascade={"persist"})
     */
    private $idea;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="string", length=500)
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="addDate", type="datetime")
     */
    private $addDate;


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
     * Set content
     *
     * @param string $content
     *
     * @return comment
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
     * Set addDate
     *
     * @param \DateTime $addDate
     *
     * @return comment
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
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return comment
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->User = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->User;
    }

    /**
     * Set idea
     *
     * @param \AppBundle\Entity\idea $idea
     *
     * @return comment
     */
    public function setIdea(\AppBundle\Entity\idea $idea = null)
    {
        $this->idea = $idea;

        return $this;
    }

    /**
     * Get idea
     *
     * @return \AppBundle\Entity\idea
     */
    public function getIdea()
    {
        return $this->idea;
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
}
