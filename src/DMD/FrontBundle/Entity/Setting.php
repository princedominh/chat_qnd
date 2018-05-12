<?php

namespace DMD\FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Setting
 * support: string, integer, float, date, datetime
 *
 * @ORM\Table(name="front_setting")
 * @ORM\Entity(repositoryClass="DMD\FrontBundle\Repository\SettingRepository")
 */
class Setting
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
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="s_value", type="string", length=255, nullable=true)
     */
    private $sValue;

    /**
     * @var int
     *
     * @ORM\Column(name="i_value", type="integer", nullable=true)
     */
    private $iValue;

    /**
     * @var float
     *
     * @ORM\Column(name="f_value", type="float", nullable=true)
     */
    private $fValue;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="da_value", type="date", nullable=true)
     */
    private $daValue;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_value", type="datetime", nullable=true)
     */
    private $dtValue;

    /**
     * @var string
     *
     * @ORM\Column(name="data_type", type="string", length=20)
     */
    private $dataType;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;


    /**
     * Constructor 2
     */
    public function __construct($slug, $data_type, $value, $description)
    {
        $this->slug = $slug;
        $this->setSettingValue($data_type, $value, $description);
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
     * Set slug
     *
     * @param string $slug
     *
     * @return Setting
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set sValue
     *
     * @param string $sValue
     *
     * @return Setting
     */
    public function setSValue($sValue)
    {
        $this->sValue = $sValue;
        
        $this->iValue = null;
        $this->fValue = null;
        $this->daValue = null;
        $this->dtValue = null;

        return $this;
    }

    /**
     * Get sValue
     *
     * @return string
     */
    public function getSValue()
    {
        return $this->sValue;
    }

    /**
     * Set iValue
     *
     * @param integer $iValue
     *
     * @return Setting
     */
    public function setIValue($iValue)
    {
        $this->iValue = $iValue;

        $this->sValue = null;
        $this->fValue = null;
        $this->daValue = null;
        $this->dtValue = null;

        return $this;
    }

    /**
     * Get iValue
     *
     * @return int
     */
    public function getIValue()
    {
        return $this->iValue;
    }

    /**
     * Set fValue
     *
     * @param float $fValue
     *
     * @return Setting
     */
    public function setFValue($fValue)
    {
        $this->fValue = $fValue;

        $this->iValue = null;
        $this->sValue = null;
        $this->daValue = null;
        $this->dtValue = null;

        return $this;
    }

    /**
     * Get fValue
     *
     * @return float
     */
    public function getFValue()
    {
        return $this->fValue;
    }

    /**
     * Set daValue
     *
     * @param \DateTime $daValue
     *
     * @return Setting
     */
    public function setDaValue($daValue)
    {
        $this->daValue = $daValue;

        $this->iValue = null;
        $this->fValue = null;
        $this->sValue = null;
        $this->dtValue = null;

        return $this;
    }

    /**
     * Get daValue
     *
     * @return \DateTime
     */
    public function getDaValue()
    {
        return $this->daValue;
    }

    /**
     * Set dtValue
     *
     * @param \DateTime $dtValue
     *
     * @return Setting
     */
    public function setDtValue($dtValue)
    {
        $this->dtValue = $dtValue;

        $this->iValue = null;
        $this->fValue = null;
        $this->daValue = null;
        $this->sValue = null;

        return $this;
    }

    /**
     * Get dtValue
     *
     * @return \DateTime
     */
    public function getDtValue()
    {
        return $this->dtValue;
    }

    /**
     * Set dataType
     *
     * @param string $dataType
     *
     * @return Setting
     */
    public function setDataType($dataType)
    {
        $this->dataType = $dataType;

        return $this;
    }

    /**
     * Get dataType
     *
     * @return string
     */
    public function getDataType()
    {
        return $this->dataType;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Setting
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
    
    public function setSettingValue($data_type, $value, $description) {
        $this->description = $description;
        $this->dataType = $data_type;
        switch ($this->dataType) {
            case 'integer': 
                $this->setIValue($value); break;
            case 'float': 
                $this->setFValue($value); break;
            case 'string': 
                $this->setSValue($value); break;
            case 'date':
                $this->setDaValue($value); break;
            case 'datetime':
                $this->setDtValue($value); break;
            default :
                $this->setSValue($value); break;
        }
        return $this;
    }
    public function getSettingValue() {
        switch ($this->dataType) {
            case 'integer': return $this->iValue;
            case 'float': return $this->fValue;
            case 'string': return $this->sValue;
            case 'date': return $this->daValue;
            case 'datetime': return $this->dtValue;
            default : return null;
        }
    }
}

