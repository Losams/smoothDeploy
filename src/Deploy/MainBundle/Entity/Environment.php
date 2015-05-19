<?php

namespace Deploy\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Environment
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Deploy\MainBundle\Entity\EnvironmentRepository")
 */
class Environment
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
     * @ORM\Column(name="designation", type="string", length=255)
     */
    private $designation;

    /**
     * @var string
     *
     * @ORM\Column(name="defaultBranch", type="string", length=255)
     */
    private $defaultBranch;

    public function __toString(){
        return $this->designation;
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
     * Set designation
     *
     * @param string $designation
     * @return Environment
     */
    public function setDesignation($designation)
    {
        $this->designation = $designation;

        return $this;
    }

    /**
     * Get designation
     *
     * @return string 
     */
    public function getDesignation()
    {
        return $this->designation;
    }

    /**
     * Set DefaultBranch
     *
     * @param string $DefaultBranch
     * @return Environment
     */
    public function setDefaultBranch($defaultBranch)
    {
        $this->defaultBranch = $defaultBranch;

        return $this;
    }

    /**
     * Get DefaultBranch
     *
     * @return string 
     */
    public function getDefaultBranch()
    {
        return $this->defaultBranch;
    }
}
