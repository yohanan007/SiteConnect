<?php

namespace OC\BlogBundle\Entity;

use Symfony\Component\HttpFoundation\File\UploadedFile;

use Doctrine\ORM\Mapping as ORM;

/**
 * Image
 *
 * @ORM\Table(name="oc_image_bibliotheque")
 * @ORM\Entity(repositoryClass="OC\BlogBundle\Repository\ImageRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Image
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
     *@ORM\ManyToOne(targetEntity="OC\PersonnelBundle\Entity\User", inversedBy="images")
     *@ORM\JoinColumn(nullable=true)
     */ 
    private $users;    
    
    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255)
     */
    private $alt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     *@var UploadedFile
     */ 
    private $file;
    
    private $tempFilename;
    
    public function __construct()
    {
        $this->date = new \DateTime();
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
     * Set adresse
     *
     * @param string $adresse
     *
     * @return Image
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set alt
     *
     * @param string $alt
     *
     * @return Image
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Image
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
    
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */ 
     public function preUpload()
     {
         if (null === $this->file)
         {
             return;
         }
         
         $this->adresse = $this->file->guessExtension();
         $this->alt = $this->file->getClientOriginalName();
     }
    
    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */ 
    public function upload()
    {
        if (null === $this->file)
        {
            return;
        }
        
        if (null !== $this->tempFilename)
        {
            $oldfile = $this->getUploadRootDir().'/'.$this->id.'.'.$this->tempFilename;
            if (file_exists($oldfile))
                {
                unlink($oldfile);
                }
        }
        
        
        
        $this->file->move( $this->getUploadRootDir(),
        $this->id.'.'.$this->adresse );
        
       
    }
    
    /**
     * @ORM\PreRemove()
     */
     public function preRemoveUpload()
     {
         $this->tempFilename = $this->getUploadRootDir().'/'.$this->id.'.'.$this->adresse;
     }
     
    /**
     * @ORM\PostRemove()
     */
     public function removeUpload()
     {
         if(file_exists($this->tempFilename))
         {
             unlink($this->tempFilename);
         }
     }
     
     public function getWebPath()
     {
         return $this->getUploadDir().'/'.$this->getId().'.'.$this->getAdresse();
     }
    
    public function getUploadDir()
    {
        return 'uploads/img';
    }
    
    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }
    
    
    
    /**
     * @param UploadedFile 
     */
     public function getFile()
    {
        return $this->file;
    }
    
    /**
     * @param UploadedFile $file
     */ 
    public function setFile(UploadedFile $file)
    {
        $this->file = $file;
        
        if (null !== $this->adresse)
        {
            $this->tempFilename = $this->adresse;
            $this->adresse = null;
            $this->alt = null;
        }
    }

    /**
     * Set users
     *
     * @param \OC\PersonnelBundle\Entity\User $users
     *
     * @return Image
     */
    public function setUsers(\OC\PersonnelBundle\Entity\User $users = null)
    {
        $this->users = $users;

        return $this;
    }

    /**
     * Get users
     *
     * @return \OC\PersonnelBundle\Entity\User
     */
    public function getUsers()
    {
        return $this->users;
    }
}
