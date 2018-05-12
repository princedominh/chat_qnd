<?php

namespace DMD\CoffeeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * DMD\CoffeeBundle\Entity\Table
 * @author princedominh <princedominh@gmail.com>
 *
 * @ORM\Table(name="coffee_table")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Table
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
     * @ORM\ManyToOne(targetEntity="Area",inversedBy="tables")
     */
    private $area;

    /**
     * @ORM\OneToMany(targetEntity="Order", mappedBy="table", cascade={ "persist", "remove"}, orphanRemoval = true)
     */
    protected $orders;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     * @Gedmo\Slug(fields={"name","id"})
     * @ORM\Column(name="alias", type="string", length=255, unique=true)
     */
    protected $alias;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

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
     * @var boolean
     *
     * @ORM\Column(name="finished", type="boolean")
     */
    private $finished = true;
    
    /**
     * @var Order
     */
    private $current_order;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->orders = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set area
     *
     * @param \DMD\CoffeeBundle\Entity\Area $area
     * @return Table
     */
    public function setArea(\DMD\CoffeeBundle\Entity\Area $area = null)
    {
        $this->area = $area;

        return $this;
    }

    /**
     * Get area
     *
     * @return \DMD\CoffeeBundle\Entity\Area
     */
    public function getArea()
    {
        return $this->area;
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
     * Add orders
     *
     * @param \DMD\CoffeeBundle\Entity\Order $orders
     * @return Table
     */
    public function addOrders(\DMD\CoffeeBundle\Entity\Order $orders)
    {
        $this->orders[] = $orders;

        return $this;
    }

    /**
     * Remove orders
     *
     * @param \DMD\CoffeeBundle\Entity\Order $orders
     */
    public function removeOrders(\DMD\CoffeeBundle\Entity\Order $orders)
    {
        $this->orders->removeElement($orders);
    }

    /**
     * Get orders
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOrders()
    {
        return $this->orders;
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
     * Set finished
     *
     * @param boolean $finished
     * @return Table
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
     * Add orders
     *
     * @param \DMD\CoffeeBundle\Entity\Order $orders
     * @return Table
     */
    public function addOrder(\DMD\CoffeeBundle\Entity\Order $orders)
    {
        $this->orders[] = $orders;

        return $this;
    }

    /**
     * Remove orders
     *
     * @param \DMD\CoffeeBundle\Entity\Order $orders
     */
    public function removeOrder(\DMD\CoffeeBundle\Entity\Order $orders)
    {
        $this->orders->removeElement($orders);
    }
    
    /**
     * 
     * @param \DMD\CoffeeBundle\Entity\Order $order
     */
    public function setCurrentOrder(\DMD\CoffeeBundle\Entity\Order $order)
    {
        $this->current_order = $order;
    }
    
    /**
     * 
     * @return \DMD\CoffeeBundle\Entity\Order
     */
    public function getCurrentOrder()
    {
        return $this->current_order;
    }
}
