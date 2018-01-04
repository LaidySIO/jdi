<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Task
 *
 * @ORM\Table(name="task", indexes={@ORM\Index(name="fk_task_project_idx", columns={"projectmaster"}), @ORM\Index(name="fk_task_fos_user1_idx", columns={"usermaster"}), @ORM\Index(name="fk_task_priority1_idx", columns={"priorityid"})})
 * @ORM\Entity
 */
class Task
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
     * @ORM\Column(name="idtask", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idtask;

    /**
     * @var \AppBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usermaster", referencedColumnName="id")
     * })
     */
    private $usermaster;

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
     * @var \AppBundle\Entity\Project
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Project")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="projectmaster", referencedColumnName="idproject")
     * })
     */
    private $projectmaster;

    /**
     * @var string
     *
     * @ORM\Column(name="details", type="string", length=30000, nullable=true)
     */
    private $details;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\FosUser", inversedBy="tasktask")
     * @ORM\JoinTable(name="task_user",
     *   joinColumns={
     *     @ORM\JoinColumn(name="task_idtask", referencedColumnName="idtask")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="fos_user_id", referencedColumnName="id")
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
    public function getIdtask()
    {
        return $this->idtask;
    }

    /**
     * @param int $idtask
     */
    public function setIdtask($idtask)
    {
        $this->idtask = $idtask;
    }

    /**
     * @return User
     */
    public function getUsermaster()
    {
        return $this->usermaster;
    }

    /**
     * @param User $usermaster
     */
    public function setUsermaster($usermaster)
    {
        $this->usermaster = $usermaster;
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
     * @return Project
     */
    public function getProjectmaster()
    {
        return $this->projectmaster;
    }

    /**
     * @param Project $projectmaster
     */
    public function setProjectmaster($projectmaster)
    {
        $this->projectmaster = $projectmaster;
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

    /**
     * @return string
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * @param string $details
     */
    public function setDetails($details)
    {
        $this->details = $details;
    }

}

