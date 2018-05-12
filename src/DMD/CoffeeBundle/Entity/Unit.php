<?php

namespace DMD\CoffeeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Unit
 *
 * @ORM\Table(name="coffee_unit")
 * @ORM\Entity(repositoryClass="DMD\CoffeeBundle\Repository\UnitRepository")
 */
class Unit
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="UnitReference", mappedBy="unitBase")
     */
    protected $unitbases;
    
    /**
     * @ORM\OneToMany(targetEntity="UnitReference", mappedBy="unitReference")
     */
    protected $unitreferences;
    

     /**
     * Constructor
     */
    public function __construct()
    {
        $this->unitbases = new \Doctrine\Common\Collections\ArrayCollection();
        $this->unitreferences = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return Unit
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
     * to String
     */
    public function __toString()
    {
        return '' . $this->name;
    }

}

