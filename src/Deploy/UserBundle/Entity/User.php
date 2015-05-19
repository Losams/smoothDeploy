<?php
namespace Deploy\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Deploy\MainBundle\Entity\Website;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="\Deploy\MainBundle\Entity\Website", inversedBy="users", cascade={"persist"})
     */
    private $websites;

    public function __construct()
    {
        parent::__construct();
        $this->websites = new ArrayCollection();
    }

    /**
     * Add websites
     *
     * @param \Deploy\MainBundle\Entity\Website $websites
     * @return Note
     */
    public function addWebsite(\Deploy\MainBundle\Entity\Website $website)
    {
        if (!$this->websites->contains($website)) {
            $this->websites[] = $website;
        }
     
        return $this;
    }
 
    /**
     * Remove websites
     *
     * @param \Deploy\MainBundle\Entity\Website $websites
     */
    public function removeWebsite(\Deploy\MainBundle\Entity\Website $website)
    {
        $this->websites->removeElement($website);
    }
 
    /**
     * Get websites
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getwebsites()
    {
        return $this->websites;
    }

    public function hasAccess(\Deploy\MainBundle\Entity\Website $websites) {
        if ($this->websites->contains($websites)) {
            return true;
        }
        
        return false;
    }
}