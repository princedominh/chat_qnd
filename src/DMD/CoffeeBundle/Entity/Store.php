<?php

namespace DMD\CoffeeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
//use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Sonata\AdminBundle\Entity\User;

/**
 * Store
 *
 * @ORM\Table(name="coffee_store")
 * @ORM\Entity(repositoryClass="DMD\CoffeeBundle\Repository\StoreRepository")
 * @ORM\HasLifecycleCallbacks
 * @GEDMO\SoftDeleteable(fieldName="deletedAt")
 */
class Store
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=512)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=100)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="website", type="string", length=255, nullable=true)
     */
    private $website;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expired_at", type="datetime", nullable=true)
     */
    private $expiredAt;

    /**
     * @var integer
     *
     * @ORM\Column(name="max_area", type="integer")
     */
    private $maxArea = 5;

    /**
     * @var integer
     *
     * @ORM\Column(name="max_item", type="integer")
     */
    private $maxItem = 50;

    /**
     * @var integer
     *
     * @ORM\Column(name="max_order", type="integer")
     */
    private $maxOrder = 10000;

    /**
     * @var integer
     *
     * @ORM\Column(name="max_user", type="integer")
     */
    private $maxUser = 5;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var Application\Sonata\UserBundle\Entity\User
     * @ORM\OneToMany(targetEntity="\Application\Sonata\UserBundle\Entity\User", mappedBy="store", cascade={ "persist", "remove"}, orphanRemoval=true)
     */
    private $users;
    

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
     *
     * @return Store
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
     * Set slug
     *
     * @param string $slug
     *
     * @return Store
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
     * Set address
     *
     * @param string $address
     *
     * @return Store
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Store
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set website
     *
     * @param string $website
     *
     * @return Store
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Get website
     *
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Store
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Store
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
     *
     * @return Store
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
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     *
     * @return Store
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
     * Set expiredAt
     *
     * @param \DateTime $expiredAt
     *
     * @return Store
     */
    public function setExpiredAt($expiredAt)
    {
        $this->expiredAt = $expiredAt;

        return $this;
    }

    /**
     * Get expiredAt
     *
     * @return \DateTime
     */
    public function getExpiredAt()
    {
        return $this->expiredAt;
    }

    /**
     * Set maxArea
     *
     * @param integer $maxArea
     *
     * @return Store
     */
    public function setMaxArea($maxArea)
    {
        $this->maxArea = $maxArea;

        return $this;
    }

    /**
     * Get maxArea
     *
     * @return integer
     */
    public function getMaxArea()
    {
        return $this->maxArea;
    }

    /**
     * Set maxItem
     *
     * @param integer $maxItem
     *
     * @return Store
     */
    public function setMaxItem($maxItem)
    {
        $this->maxItem = $maxItem;

        return $this;
    }

    /**
     * Get maxItem
     *
     * @return integer
     */
    public function getMaxItem()
    {
        return $this->maxItem;
    }

    /**
     * Set maxOrder
     *
     * @param integer $maxOrder
     *
     * @return Store
     */
    public function setMaxOrder($maxOrder)
    {
        $this->maxOrder = $maxOrder;

        return $this;
    }

    /**
     * Get maxOrder
     *
     * @return integer
     */
    public function getMaxOrder()
    {
        return $this->maxOrder;
    }

    /**
     * Set maxUser
     *
     * @param integer $maxUser
     *
     * @return Store
     */
    public function setMaxUser($maxUser)
    {
        $this->maxUser = $maxUser;

        return $this;
    }

    /**
     * Get maxUser
     *
     * @return integer
     */
    public function getMaxUser()
    {
        return $this->maxUser;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Store
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
}

