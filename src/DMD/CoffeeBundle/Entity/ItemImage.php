<?php

namespace DMD\CoffeeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as GEDMO;


/**
 * DMD\CoffeeBundle\Entity\ProductImage
 * @author princedominh <princedominh@gmail.com>
 *
 * @ORM\Table(name="coffee_item_image")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class ItemImage
{
    const image_path = 'bundles/coffee/images';
    
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Item",inversedBy="images")
     */
    private $item;
    
    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @Assert\File(
     *      maxSize="6000000",
     *      mimeTypes = {"image/jpeg", "image/gif", "image/bmp", "image/png"},
     *      mimeTypesMessage = "Please upload a valid image (.jpeg, .gif, .bmp, .png)"
     * )
     */
    public $file;


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
     * Set path
     *
     * @param string $path
     * @return ProductImage
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return empty($this->path) ? '' : $this->path;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return ProductImage
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set item
     *
     * @param \DMD\CoffeeBundle\Entity\Item $item
     * @return ItemImage
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
    
    
    //get Image Source path
    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->path;
    }
    public function getWebPath()
    {
        return null === $this->path ? null : $this->getUploadDir().'/'.$this->path;
    }
    
    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }
    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw when displaying uploaded doc/image in the view.
        return self::image_path;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->file) {
            // do whatever you want to generate a unique name
            $this->path = $this->product->getAlias() . '-' .uniqid().'.'.$this->file->guessExtension();
            $this->title = $this->product->getAlias();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->file) {
            return;
        }
        
        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
//        echo $this->getUploadRootDir();die;
        $this->file->move($this->getUploadRootDir(), $this->path);

        unset($this->file);
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            unlink($file);
        }
    }

}
