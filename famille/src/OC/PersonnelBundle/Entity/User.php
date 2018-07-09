<?php

//entité de gestion des utilisateurs, lié à fosuserbundle
//src/OC/PersonnelBundle/Entity/User.php
 
namespace OC\PersonnelBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Consraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="fos_user")
 * @ORM\Entity
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     *@ORM\OneToMany(targetEntity="OC\BlogBundle\Entity\Image", mappedBy="users")
     * 
     */ 
    private $images;

   public function __construct()
   {
       parent::__construct();
       $this->images = new ArrayCollection();
   }


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
     * Add image
     *
     * @param \OC\BlogBundle\Entity\image $image
     *
     * @return User
     */
    public function addImage(\OC\BlogBundle\Entity\image $image)
    {
        $this->images[] = $image;

        return $this;
    }

    /**
     * Remove image
     *
     * @param \OC\BlogBundle\Entity\Image $image
     */
    public function removeImage(\OC\BlogBundle\Entity\image $image)
    {
        $this->images->removeElement($image);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->images;
    }
}
