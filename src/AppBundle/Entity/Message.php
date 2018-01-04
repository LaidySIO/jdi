<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Message
 *
 * @ORM\Table(name="message")
 * @ORM\Entity
 */
class Message
{
    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text", nullable=false)
     */
    private $message;

    /**
     * @var \AppBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="expeditor", referencedColumnName="id")
     * })
     */
    private $expeditor;

    /**
     * @var string
     *
     * @ORM\Column(name="subject", type="text", nullable=false)
     */
    private $subject;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var integer
     *
     * @ORM\Column(name="idmessage", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idmessage;

    /*/**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\FosUser", inversedBy="idmessage")
     * @ORM\JoinTable(name="message_user",
     *   joinColumns={
     *     @ORM\JoinColumn(name="idmessage", referencedColumnName="idmessage")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *   }
     * )
     */
   /* private $user;

    /**
     * Constructor
     */
    /*public function __construct()
    {
        $this->user = new \Doctrine\Common\Collections\ArrayCollection();
    }
    */
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\FosUser", inversedBy="idmessage")
     * @ORM\JoinTable(name="message_user",
     *   joinColumns={
     *     @ORM\JoinColumn(name="idmessage", referencedColumnName="idmessage")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *   }
     * )
     */
    private $fosUser;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fosUser = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return int
     */
    public function getIdmessage()
    {
        return $this->idmessage;
    }

    /**
     * @param int $idmessage
     */
    public function setIdmessage($idmessage)
    {
        $this->idmessage = $idmessage;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFosUser()
    {
        return $this->fosUser;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $fosUser
     */
    public function setFosUser($fosUser)
    {
        $this->fosUser = $fosUser;
    }
    /*
        /**
         * @return \Doctrine\Common\Collections\Collection
         */
   /* public function getUser()
    {
        return $this->user;
    }
*/
  /*  /**
     * @param \Doctrine\Common\Collections\Collection $user
     */
   /* public function setUser($user)
    {
        $this->user = $user;
    }
*/

    public function __toString()
    {
        return $this->subject;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getExpeditor()
    {
        return $this->expeditor;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $expeditor
     */
    public function setExpeditor($expeditor)
    {
        $this->expeditor = $expeditor;
    }



}

