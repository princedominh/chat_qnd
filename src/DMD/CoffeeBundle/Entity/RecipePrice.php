<?php

namespace DMD\CoffeeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * DMD\CoffeeBundle\Entity\RecipePrice
 * @author princedominh <princedominh@gmail.com>
 *
 * @ORM\Table(name="coffee_recipe_price")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks
 */
class RecipePrice
{
    
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Recipe",inversedBy="prices")
     */
    private $recipe;
    
    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    protected $price;

    /**
     * @ORM\Column(name="used_at", type="datetime")
     */
    private $usedAt;

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
     * Set price
     *
     * @param float $price
     * @return ItemPrice
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set usedAt
     *
     * @param \DateTime $usedAt
     * @return ItemPrice
     */
    public function setUsedAt($usedAt)
    {
        $this->usedAt = $usedAt;

        return $this;
    }

    /**
     * Get usedAt
     *
     * @return \DateTime 
     */
    public function getUsedAt()
    {
        return $this->usedAt;
    }

    /**
     * Set Recipe
     *
     * @param \DMD\CoffeeBundle\Entity\Recipe $item
     * @return ItemPrice
     */
    public function setRecipe(\DMD\CoffeeBundle\Entity\Recipe $recipe = null)
    {
        $this->recipe = $recipe;

        return $this;
    }

    /**
     * Get Recipe
     *
     * @return \DMD\CoffeeBundle\Entity\Recipe
     */
    public function getRecipe()
    {
        return $this->recipe;
    }

}
