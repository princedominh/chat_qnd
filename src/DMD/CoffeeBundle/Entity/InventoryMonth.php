<?php

namespace DMD\CoffeeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InventoryMonth
 *
 * @ORM\Table(name="inventory_month")
 * @ORM\Entity(repositoryClass="DMD\CoffeeBundle\Repository\InventoryMonthRepository")
 */
class InventoryMonth
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
     * @ORM\Column(name="used_at", type="datetime")
     */
    private $usedAt;

    /**
     * @var float
     *
     * @ORM\Column(name="quantity", type="float")
     */
    private $quantity;


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
     * Set usedAt
     *
     * @param \DateTime $usedAt
     *
     * @return InventoryMonth
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
     * Set quantity
     *
     * @param float $quantity
     *
     * @return InventoryMonth
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
}

