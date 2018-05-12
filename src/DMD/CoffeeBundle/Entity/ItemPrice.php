<?php

namespace DMD\CoffeeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * DMD\CoffeeBundle\Entity\ItemPrice
 * @author princedominh <princedominh@gmail.com>
 *
 * @ORM\Table(name="coffee_item_price")
 * @ORM\Entity(repositoryClass="DMD\CoffeeBundle\Repository\ItemPriceRepository")
 * @ORM\HasLifecycleCallbacks
 */
class ItemPrice
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
     * @ORM\ManyToOne(targetEntity="Item",inversedBy="prices")
     */
    private $item;
    
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
     * Set item
     *
     * @param \DMD\CoffeeBundle\Entity\Item $item
     * @return ItemPrice
     */
    public function setItem(\DMD\CoffeeBundle\Entity\Item $item = null)
    {
        $this->item = $item;

        return $this;
    }

    /**
     * Get item
     *
     * @return \DMD\CoffeeBundle\Entity\Item
     */
    public function getItem()
    {
        return $this->item;
    }

}
