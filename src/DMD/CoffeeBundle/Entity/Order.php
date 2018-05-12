<?php

namespace DMD\CoffeeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as GEDMO;


/**
 * DMD\CoffeeBundle\Entity\Order
 * @author princedominh <princedominh@gmail.com>
 *
 * @ORM\Table(name="coffee_order")
 * @ORM\Entity(repositoryClass="DMD\CoffeeBundle\Repository\OrderRepository")
 * @ORM\HasLifecycleCallbacks
 * @GEDMO\SoftDeleteable(fieldName="deletedAt")
 */
class Order
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
     * @ORM\ManyToOne(targetEntity="Table",inversedBy="orders")
     */
    private $table;
    
    /**
     * @ORM\OneToMany(targetEntity="OrderDetail", mappedBy="order", cascade={"all"},orphanRemoval = true)
     */
    private $order_details;
    
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="finished", type="boolean")
     */
    private $finished = false;

    /**
     * @var integer
     *
     * @ORM\Column(name="total", type="integer")
     */
    private $total = 0;

    /**
     * @ORM\OneToMany(targetEntity="OrderPrinted", mappedBy="order", cascade={"all"},orphanRemoval = true)
     */
    private $order_printed;
    
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
//        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * toString
     */
    public function __toString()
    {
        return '' . $this->name;
    }

    /**
     * Set id
     *
     * @param integer $id
     * @return Order
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
     * @return Order
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
     * Set table
     *
     * @param \DMD\CoffeeBundle\Entity\Table $table
     * @return Order
     */
    public function setTable(\DMD\CoffeeBundle\Entity\Table $table = null)
    {
        $this->table = $table;

        return $this;
    }

    /**
     * Get table
     *
     * @return \DMD\CoffeeBundle\Entity\Table
     */
    public function getTable()
    {
        return $this->table;
    }



    /**
     * Set description
     *
     * @param string $description
     * @return Order
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
     * Add order_details
     *
     * @param \DMD\CoffeeBundle\Entity\OrderDetail $orderDetails
     * @return Order
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
     * Set finished
     *
     * @param boolean $finished
     * @return Order
     */
    public function setFinished($finished)
    {
        $this->finished = $finished;

        return $this;
    }

    /**
     * Get finished
     *
     * @return boolean 
     */
    public function getFinished()
    {
        return $this->finished;
    }

    /**
     * Add order_printed
     *
     * @param \DMD\CoffeeBundle\Entity\OrderPrinted $orderPrinted
     * @return Order
     */
    public function addOrderPrinted(\DMD\CoffeeBundle\Entity\OrderPrinted $orderPrinted)
    {
        $this->order_printed[] = $orderPrinted;

        return $this;
    }

    /**
     * Remove order_printed
     *
     * @param \DMD\CoffeeBundle\Entity\OrderPrinted $orderPrinted
     */
    public function removeOrderPrinted(\DMD\CoffeeBundle\Entity\OrderPrinted $orderPrinted)
    {
        $this->order_printed->removeElement($orderPrinted);
    }

    /**
     * Get order_printed
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOrderPrinted()
    {
        return $this->order_printed;
    }

    /**
     * Set total
     *
     * @param integer $total
     * @return Order
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return integer 
     */
    public function getTotal()
    {
        return $this->total;
    }
}
