<?php

namespace OC\GestionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Article
 *
 * @ORM\Table(name="oc_article")
 * @ORM\Entity(repositoryClass="OC\GestionBundle\Repository\ArticleRepository")
 */
class Article
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
     * @ORM\ManyToOne(targetEntity="Section", inversedBy="articles")
     * @ORM\JoinColumn(name="oc_section_id", referencedColumnName="id")
     */ 
    private $section;
  
    /**
     * @ORM\OneToOne(targetEntity="ImageA", cascade={"persist"})
     */ 
    private $imageAs;
    
     /**
     * @ORM\OneToOne(targetEntity="TextA", cascade={"persist"})
     */ 
    private $textAs;
    
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;
    
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
     * Set nom
     *
     * @param string $nom
     *
     * @return Article
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Article
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
     * Set section
     *
     * @param \OC\GestionBundle\Entity\Section $section
     *
     * @return Article
     */
    public function setSection(\OC\GestionBundle\Entity\Section $section = null)
    {
        $this->section = $section;

        return $this;
    }

    /**
     * Get section
     *
     * @return \OC\GestionBundle\Entity\Section
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * Set imageAs
     *
     * @param \OC\GestionBundle\Entity\ImageA $imageAs
     *
     * @return Article
     */
    public function setImageAs(\OC\GestionBundle\Entity\ImageA $imageAs = null)
    {
        $this->imageAs = $imageAs;

        return $this;
    }

    /**
     * Get imageAs
     *
     * @return \OC\GestionBundle\Entity\ImageA
     */
    public function getImageAs()
    {
        return $this->imageAs;
    }

    /**
     * Set textAs
     *
     * @param \OC\GestionBundle\Entity\TextA $textAs
     *
     * @return Article
     */
    public function setTextAs(\OC\GestionBundle\Entity\TextA $textAs = null)
    {
        $this->textAs = $textAs;

        return $this;
    }

    /**
     * Get textAs
     *
     * @return \OC\GestionBundle\Entity\TextA
     */
    public function getTextAs()
    {
        return $this->textAs;
    }
}
