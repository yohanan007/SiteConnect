<?php

namespace OC\GestionBundle\Entity;

use Symfony\Component\HttpFoundation\File\UploadedFile;

use Doctrine\ORM\Mapping as ORM;

/**
 * ImageA
 *
 * @ORM\Table(name="oc_image_a")
 * @ORM\Entity(repositoryClass="OC\GestionBundle\Repository\ImageARepository")
 * @ORM\HasLifecycleCallbacks
 */
class ImageA
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
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

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
     * @var UploadedFile
     */ 
    private $file;
    
    private $tempFilename;
    
    
    public function __construct()
    {
        $this->date = new \Datetime();
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
     * Set titre
     *
     * @param string $titre
     *
     * @return ImageA
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return ImageA
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set alt
     *
     * @param string $alt
     *
     * @return ImageA
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
     * @return ImageA
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
         
         $this->url = $this->file->guessExtension();
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
        $this->id.'.'.$this->url );
        
       
    }
    
    /**
     * @ORM\PreRemove()
     */
     public function preRemoveUpload()
     {
         $this->tempFilename = $this->getUploadRootDir().'/'.$this->id.'.'.$this->url;
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
         return $this->getUploadDir().'/'.$this->getId().'.'.$this->getUrl();
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
        
        if (null !== $this->url)
        {
            $this->tempFilename = $this->url;
            $this->url = null;
            $this->alt = null;
        }
    }
    
}
