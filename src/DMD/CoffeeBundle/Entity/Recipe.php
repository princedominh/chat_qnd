<?php

namespace DMD\CoffeeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Recipe
 *
 * @ORM\Table(name="coffee_recipe")
 * @ORM\Entity(repositoryClass="DMD\CoffeeBundle\Repository\RecipeRepository")
 */
class Recipe
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
     * @ORM\ManyToOne(targetEntity="Item",inversedBy="recipes")
     * @ORM\JoinColumn(name="item_id", referencedColumnName="id")
     */
    private $item;

    /**
     * @ORM\ManyToOne(targetEntity="Material",inversedBy="recipes")
     * @ORM\JoinColumn(name="material_id", referencedColumnName="id")
     */
    private $material;

    /**
     * @ORM\ManyToOne(targetEntity="Unit",inversedBy="recipes")
     * @ORM\JoinColumn(name="unit_id", referencedColumnName="id")
     */
    private $unit;

    /**
     * @var float
     *
     * @ORM\Column(name="quantity", type="float")
     */
    private $quantity;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="RecipePrice", mappedBy="recipe", cascade={"all"},orphanRemoval = true)
     */
    private $prices;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="current_price", type="integer", length=100, nullable=true, options={"default":0})
     */
    private $current_price;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->prices = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set Item
     *
     * @param Item $item
     *
     * @return Recipe
     */
    public function setItem($item)
    {
        $this->item = $item;

        return $this;
    }

    /**
     * Get Item
     *
     * @return Item
     */
    public function getItem()
    {
        return $this->item;
    }
    
    /**
     * Set Material
     *
     * @param Material $material
     *
     * @return UnitReference
     */
    public function setMaterial($material)
    {
        $this->material = $material;

        return $this;
    }

    /**
     * Get Material
     *
     * @return Unit
     */
    public function getMaterial()
    {
        return $this->material;
    }
    
    /**
     * Set Unit
     *
     * @param Unit $unit
     *
     * @return UnitReference
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * Get Unit
     *
     * @return Unit
     */
    public function getUnit()
    {
        return $this->unit;
    }
    
    /**
     * Set quantity
     *
     * @param float $quantity
     *
     * @return Recipe
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return float
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Recipe
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
    
    /**
     * Set current_price
     *
     * @param integer $currentPrice
     * @return Item
     */
    public function setCurrentPrice($currentPrice)
    {
        $this->current_price = $currentPrice;

        return $this;
    }

    /**
     * Get current_price
     *
     * @return integer 
     */
    public function getCurrentPrice()
    {
        return $this->current_price;
    }

    /**
     * Add prices
     *
     * @param \DMD\CoffeeBundle\Entity\RecipePrice $prices
     * @return Item
     */
    public function addPrice(\DMD\CoffeeBundle\Entity\RecipePrice $prices)
    {
        $this->prices[] = $prices;

        return $this;
    }

    /**
     * Remove prices
     *
     * @param \DMD\CoffeeBundle\Entity\RecipePrice $prices
     */
    public function removePrice(\DMD\CoffeeBundle\Entity\RecipePrice $prices)
    {
        $this->prices->removeElement($prices);
    }

    /**
     * Get prices
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPrices()
    {
        return $this->prices;
    }

}

