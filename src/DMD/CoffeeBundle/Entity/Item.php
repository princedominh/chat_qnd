<?php

namespace DMD\CoffeeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * DMD\CoffeeBundle\Entity\Item
 * @author princedominh <princedominh@gmail.com>
 *
 * @ORM\Table(name="coffee_item")
 * @ORM\Entity(repositoryClass="DMD\CoffeeBundle\Repository\ItemRepository")
 * @ORM\HasLifecycleCallbacks
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
class Item
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
     * @ORM\ManyToOne(targetEntity="Category",inversedBy="items")
     */
    private $category;
    
    /**
     * @ORM\OneToMany(targetEntity="OrderDetail", mappedBy="order", cascade={"all"},orphanRemoval = true)
     */
    private $order_details;
    
    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @ORM\OneToMany(targetEntity="ItemImage", mappedBy="item", cascade={ "persist", "remove"}, orphanRemoval=true)
     */
    private $images;
    
    /**
     * @ORM\OneToMany(targetEntity="ItemPrice", mappedBy="item", cascade={"all"},orphanRemoval = true)
     */
    private $prices;
    
    /**
     * @ORM\OneToMany(targetEntity="Recipe", mappedBy="item", cascade={"all"},orphanRemoval = true)
     */
    private $recipes;
    
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     * 
     * @Gedmo\Slug(fields={"name","id"})
     * @ORM\Column(name="alias", type="string", length=255, unique=true)
     */
    private $alias;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="unit", type="string", length=100, nullable=true)
     */
    private $unit;

    /**
     * @var integer
     *
     * @ORM\Column(name="current_price", type="integer", length=100, nullable=true)
     */
    private $current_price;

    /**
     * @var integer
     * Giá gốc ước lượng hiện tại
     *
     * @ORM\Column(name="current_cost", type="integer", length=100, nullable=true, options={"default":0})
     */
    private $current_cost;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_star", type="boolean")
     */
    private $is_star = false;

    /**
     * @var string
     *
     * @ORM\Column(name="recipe_string", type="text", nullable=true)
     */
    private $recipe_string;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(name="updated_at", type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
        $this->prices = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * toString
     */
    public function __toString()
    {
        return '' . $this->name;
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
     * @return Product
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
     * Set alias
     *
     * @param string $alias
     * @return Product
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Get alias
     *
     * @return string 
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Set is_star
     *
     * @param boolean $isStar
     * @return Product
     */
    public function setIsStar($isStar)
    {
        $this->is_star = $isStar;

        return $this;
    }

    /**
     * Get is_star
     *
     * @return boolean 
     */
    public function getIsStar()
    {
        return $this->is_star;
    }    

    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     * @return Product
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return \DateTime 
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Product
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Product
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    
    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }
    
    /**
     * @ORM\PreUpdate()
     */
    public function preUpdate()
    {
        $this->updatedAt = new \DateTime();
    }

    /**
     * Set category
     *
     * @param \DMD\CoffeeBundle\Entity\Category $category
     * @return Item
     */
    public function setCategory(\DMD\CoffeeBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \DMD\CoffeeBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Add images
     *
     * @param \DMD\CoffeeBundle\Entity\ItemImage $images
     * @return Product
     */
    public function addImage(\DMD\CoffeeBundle\Entity\ItemImage $images)
    {
        $this->images[] = $images;

        return $this;
    }

    /**
     * Remove images
     *
     * @param \DMD\CoffeeBundle\Entity\ItemImage $images
     */
    public function removeImage(\DMD\CoffeeBundle\Entity\ItemImage $images)
    {
        $this->images->removeElement($images);
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

    /**
     * Set description
     *
     * @param string $description
     * @return Product
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
     * Set unit
     *
     * @param string $unit
     * @return Product
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * Get unit
     *
     * @return string 
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Add prices
     *
     * @param \DMD\CoffeeBundle\Entity\ItemPrice $prices
     * @return Item
     */
    public function addPrice(\DMD\CoffeeBundle\Entity\ItemPrice $prices)
    {
        $this->prices[] = $prices;

        return $this;
    }

    /**
     * Remove prices
     *
     * @param \DMD\CoffeeBundle\Entity\ItemPrice $prices
     */
    public function removePrice(\DMD\CoffeeBundle\Entity\ItemPrice $prices)
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

    /**
     * Add recipes
     *
     * @param \DMD\CoffeeBundle\Entity\Recipe $recipes
     * @return Item
     */
    public function addRecipe(\DMD\CoffeeBundle\Entity\Recipe $recipes)
    {
        $this->recipes[] = $recipes;

        return $this;
    }

    /**
     * Remove recipes
     *
     * @param \DMD\CoffeeBundle\Entity\ItemPrice $recipes
     */
    public function removeRecipe(\DMD\CoffeeBundle\Entity\Recipe $recipes)
    {
        $this->recipes->removeElement($recipes);
    }

    /**
     * Get recipes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRecipes()
    {
        return $this->recipes;
    }


    /**
     * Add order_details
     *
     * @param \DMD\CoffeeBundle\Entity\OrderDetail $orderDetails
     * @return Item
     */
    public function addOrderDetail(\DMD\CoffeeBundle\Entity\OrderDetail $orderDetails)
    {
        $this->order_details[] = $orderDetails;

        return $this;
    }

    /**
     * Remove order_details
     *
     * @param \DMD\CoffeeBundle\Entity\OrderDetail $orderDetails
     */
    public function removeOrderDetail(\DMD\CoffeeBundle\Entity\OrderDetail $orderDetails)
    {
        $this->order_details->removeElement($orderDetails);
    }

    /**
     * Get order_details
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOrderDetails()
    {
        return $this->order_details;
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
     * Set CurrentCost
     *
     * @param integer $currentInterest
     * @return Item
     */
    public function setCurrentCost($currentCost)
    {
        $this->current_cost = $currentCost;

        return $this;
    }

    /**
     * Get CurrentCost
     *
     * @return integer 
     */
    public function getCurrentCost()
    {
        return $this->current_cost;
    }

    /**
     * Set recipe_string
     *
     * @param string $recipe_string
     * @return Item
     */
    public function setRecipeString($recipe_string)
    {
        $this->recipe_string = $recipe_string;

        return $this;
    }

    /**
     * Get recipe_string
     *
     * @return string 
     */
    public function getRecipeString()
    {
        return $this->recipe_string;
    }
}
