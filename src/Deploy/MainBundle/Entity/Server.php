<?php

namespace Deploy\MainBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Deploy\MainBundle\Entity\Website;
use Doctrine\ORM\Mapping as ORM;

/**
 * Server
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Deploy\MainBundle\Entity\ServerRepository")
 */
class Server
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
     * @var string
     *
     * @ORM\Column(name="ip", type="string", length=255)
     */
    private $ip;

    /**
     * @ORM\OneToMany(targetEntity="\Deploy\MainBundle\Entity\Website", mappedBy="server", cascade={"remove", "persist"})
     */
    protected $websites;

    public function __construct()
    {
        $this->websites = new ArrayCollection();
    }


    public function __toString(){
        return $this->name;
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
     * @return Server
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
     * Set ip
     *
     * @param string $ip
     * @return Server
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string 
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Add websites
     *
     * @param \Deploy\MainBundle\Entity\Website $websites
     * @return Server
     */
    public function addWebsite(\Deploy\MainBundle\Entity\Website $websites)
    {
        $this->websites[] = $websites;

        return $this;
    }

    /**
     * Remove websites
     *
     * @param \Deploy\MainBundle\Entity\Website $websites
     */
    public function removeWebsite(\Deploy\MainBundle\Entity\Website $websites)
    {
        $this->websites->removeElement($websites);
    }

    /**
     * Get websites
     *
     * @return \Doctrine\Common\Collections\ArrayCollection 
     */
    public function getWebsites()
    {
        return $this->websites;
    }
}
