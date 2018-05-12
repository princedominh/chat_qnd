<?php

namespace DMD\CoffeeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InventoryReceivingVoucher
 *
 * @ORM\Table(name="coffee_inventory_receiving_voucher")
 * @ORM\Entity(repositoryClass="DMD\CoffeeBundle\Repository\InventoryReceivingVoucherRepository")
 * @ORM\HasLifecycleCallbacks
*/
class InventoryReceivingVoucher
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
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="Material",inversedBy="InventoryReceivingVouchers")
     * @ORM\JoinColumn(name="material_id", referencedColumnName="id")
     */
    private $material;

    /**
     * @ORM\ManyToOne(targetEntity="Unit",inversedBy="InventoryReceivingVouchers")
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
     * @var integer
     *
     * @ORM\Column(name="price", type="integer")
     */
    private $price;

    
    /**
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User",inversedBy="InventoryReceivingVouchers")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;


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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return InventoryReceivingVoucher
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
     * Set Material
     *
     * @param Material $material
     *
     * @return InventoryReceivingVoucher
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
     * @return InventoryReceivingVoucher
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
     * Set User
     *
     * @param Unit $user
     *
     * @return InventoryReceivingVoucher
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get User
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
    
    
    
    /**
     * Set quantity
     *
     * @param float $quantity
     *
     * @return InventoryReceivingVoucher
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
     * Set Price
     *
     * @param float $quantity
     *
     * @return InventoryReceivingVoucher
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get Price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }
    
    /**
     * Set description
     *
     * @param string $description
     *
     * @return InventoryReceivingVoucher
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
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
        $this->createdAt = new \DateTime();
    }

}

