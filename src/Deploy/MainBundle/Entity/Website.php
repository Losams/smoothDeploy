<?php

namespace Deploy\MainBundle\Entity;
use Deploy\MainBundle\Entity\Server;
use Doctrine\ORM\Mapping as ORM;

/**
 * Website
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Deploy\MainBundle\Entity\WebsiteRepository")
 */
class Website
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="\Deploy\MainBundle\Entity\Environment")
     * @ORM\JoinColumn(name="environment_id", referencedColumnName="id")
     */
    protected $environment;

    /**
     * @var string
     *
     * @ORM\Column(name="ssh_user", type="string", length=255)
     */
    private $sshUser;

    /**
     * @var string
     *
     * @ORM\Column(name="ssh_pwd", type="string", length=255)
     */
    private $sshPwd;

    /**
     * @var string
     *
     * @ORM\Column(name="ssh_path", type="string", length=255)
     */
    private $sshPath;

    /**
     * @ORM\ManyToOne(targetEntity="\Deploy\MainBundle\Entity\Server", inversedBy="websites", cascade={"persist"})
     * @ORM\JoinColumn(name="server_id", referencedColumnName="id")
     */
    protected $server;

    /**
     * @ORM\ManyToMany(targetEntity="\Deploy\UserBundle\Entity\User", inversedBy="websites", cascade={"remove", "persist"})
     */
    private $users;

    /**
     * Set server
     *
     * @param object $server
     * @return Website
     */
    public function setServer($server)
    {
        $this->server = $server;

        return $this;
    }

    /**
     * Get server
     *
     * @return \Deploy\MainBundle\Entity\Server
     */
    public function getServer()
    {
        return $this->server;
    }


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Website
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set environment
     *
     * @param integer $environment
     * @return Website
     */
    public function setEnvironment($environment)
    {
        $this->environment = $environment;

        return $this;
    }

    /**
     * Get environment
     *
     * @return integer 
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * Set sshUser
     *
     * @param string $sshUser
     * @return Website
     */
    public function setSshUser($sshUser)
    {
        $this->sshUser = $sshUser;

        return $this;
    }

    /**
     * Get sshUser
     *
     * @return string 
     */
    public function getSshUser()
    {
        return $this->sshUser;
    }

    /**
     * Set sshPwd
     *
     * @param string $sshPwd
     * @return Website
     */
    public function setSshPwd($sshPwd)
    {
        $this->sshPwd = $sshPwd;

        return $this;
    }

    /**
     * Get sshPwd
     *
     * @return string 
     */
    public function getSshPwd()
    {
        return $this->sshPwd;
    }

    /**
     * Set sshPath
     *
     * @param string $sshPath
     * @return Website
     */
    public function setSshPath($sshPath)
    {
        $this->sshPath = $sshPath;

        return $this;
    }

    /**
     * Get sshPath
     *
     * @return string 
     */
    public function getSshPath()
    {
        return $this->sshPath;
    }

    /**
     * Get users
     *
     * @return string 
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Add user
     *
     * @param \Deploy\UserBundle\Entity\User $user
     * @return this
     */
    public function addUser(\Deploy\UserBundle\Entity\User $user)
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
        }
     
        return $this;
    }
 
    /**
     * Remove users
     *
     * @param \Deploy\UserBundle\Entity\User $user
     */
    public function removeUser(\Deploy\UserBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
    }
}
