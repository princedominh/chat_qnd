<?php

namespace DMD\CoffeeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UnitReference
 *
 * @ORM\Table(name="coffee_unit_reference")
 * @ORM\Entity(repositoryClass="DMD\CoffeeBundle\Repository\UnitReferenceRepository")
 */
class UnitReference
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
     * @ORM\ManyToOne(targetEntity="Material",inversedBy="unitReferences")
     * @ORM\JoinColumn(name="material_id", referencedColumnName="id")
     */
    private $material;

    /**
     * @ORM\ManyToOne(targetEntity="Unit",inversedBy="unitbases")
     * @ORM\JoinColumn(name="unit_base_id", referencedColumnName="id")
     */
    private $unitBase;

    /**
     * @ORM\ManyToOne(targetEntity="Unit",inversedBy="unitreferences")
     * @ORM\JoinColumn(name="unit_ref_id", referencedColumnName="id")
     */
    private $unitReference;

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
     * Set UnitBase
     *
     * @param Unit $unit_base
     *
     * @return UnitReference
     */
    public function setUnitBase($unit_base)
    {
        $this->unitBase = $unit_base;

        return $this;
    }

    /**
     * Get UnitBase
     *
     * @return Unit
     */
    public function getUnitBase()
    {
        return $this->unitBase;
    }
    
    /**
     * Set UnitReference
     *
     * @param Unit $unit_ref
     *
     * @return UnitReference
     */
    public function setUnitReference($unit_ref)
    {
        $this->unitReference = $unit_ref;

        return $this;
    }

    /**
     * Get UnitReference
     *
     * @return Unit
     */
    public function getUnitReference()
    {
        return $this->unitReference;
    }
    
    /**
     * Set quantity
     *
     * @param float $quantity
     *
     * @return UnitReference
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

