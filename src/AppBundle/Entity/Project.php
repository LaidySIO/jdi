<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Project
 *
 * @ORM\Table(name="project", indexes={@ORM\Index(name="fk_project_fos_user1_idx", columns={"master"}), @ORM\Index(name="fk_project_priority1_idx", columns={"priorityid"})})
 * @ORM\Entity
 */
class Project
{
    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=255, nullable=false)
     */
    private $libelle;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creationdate", type="datetime", nullable=false)
     */
    private $creationdate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="limitedate", type="datetime", nullable=true)
     */
    private $limitedate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="enddate", type="datetime", nullable=true)
     */
    private $enddate;

    /**
     * @var integer
     *
     * @ORM\Column(name="idproject", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idproject;

    /**
     * @var \AppBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="master", referencedColumnName="id")
     * })
     */
    private $master;

    /**
     * @var \AppBundle\Entity\Priority
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Priority")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="priorityid", referencedColumnName="idpriority")
     * })
     */
    private $priorityid;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\FosUser", inversedBy="idproject")
     * @ORM\JoinTable(name="project_user",
     *   joinColumns={
     *     @ORM\JoinColumn(name="idproject", referencedColumnName="idproject")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *   }
     * )
     */
//    private $user;

    /**
     * Constructor
     */
    /*public function __construct()
    {
        $this->user = new \Doctrine\Common\Collections\ArrayCollection();
    }*/

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
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * @param string $libelle
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
    }

    /**
     * @return \DateTime
     */
    public function getCreationdate()
    {
        return $this->creationdate;
    }

    /**
     * @param \DateTime $creationdate
     */
    public function setCreationdate($creationdate)
    {
        $this->creationdate = $creationdate;
    }

    /**
     * @return \DateTime
     */
    public function getLimitedate()
    {
        return $this->limitedate;
    }

    /**
     * @param \DateTime $limitedate
     */
    public function setLimitedate($limitedate)
    {
        $this->limitedate = $limitedate;
    }

    /**
     * @return \DateTime
     */
    public function getEnddate()
    {
        return $this->enddate;
    }

    /**
     * @param \DateTime $enddate
     */
    public function setEnddate($enddate)
    {
        $this->enddate = $enddate;
    }

    /**
     * @return int
     */
    public function getIdproject()
    {
        return $this->idproject;
    }

    /**
     * @param int $idproject
     */
    public function setIdproject($idproject)
    {
        $this->idproject = $idproject;
    }

    /**
     * @return FosUser
     */
    public function getMaster()
    {
        return $this->master;
    }

    /**
     * @param FosUser $master
     */
    public function setMaster($master)
    {
        $this->master = $master;
    }

    /**
     * @return Priority
     */
    public function getPriorityid()
    {
        return $this->priorityid;
    }

    /**
     * @param Priority $priorityid
     */
    public function setPriorityid($priorityid)
    {
        $this->priorityid = $priorityid;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
  /*  public function getUser()
    {
        return $this->user;
    }*/

    /**
     * @param \Doctrine\Common\Collections\Collection $user
     */
/*    public function setUser($user)
    {
        $this->user = $user;
    }*/

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

    public function __toString()
    {
        return $this->libelle;
    }

}

