<?php

namespace DMD\CoffeeBundle\Admin\Entity;

//use Application\Sonata\AdminBundle\Admin\Admin as Admin;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Symfony\Component\HttpFoundation\RedirectResponse;


/**
 * Description of ItemImageAdmin
 *
 * @author princedominh <princedominh@gmail.com>
 */
class ItemImageAdmin extends Admin {
    const SESSION_IMAGE_SOURCE = "item_image_path";
     
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->addIdentifier('path', null, array('label'=>'product.label.name'))
                ->add('_action', 'actions', array(
                        'actions' => array(
                        'view' => array(),
                        'delete' => array(),
                        )));
        parent::configureListFields($listMapper);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('item')
            ->add('path')
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $itemImage = $this->getSubject();
        if (!empty($itemImage)) {
            $image_source = $itemImage->getPath();
            $session = $this->getRequest()->getSession();
            $session->set(self::SESSION_IMAGE_SOURCE . $itemImage->getId(), $image_source);
        } else {
            $image_source = '';
        }
                
        $formMapper
//            ->add('product', 'sonata_type_model', array('required' => false))
//            ->add('path', 'hidden', array('required' => true))
            ->add('file', 'file',array('required'=>($image_source=='')))
        ;
    }
    
    protected function configureShowFields(\Sonata\AdminBundle\Show\ShowMapper $filter) {
        $filter
            ->add('item')
            ->add('path')
        ;
        parent::configureShowFields($filter);
    }

    public function update($object)
    {
        parent::update($object);
        
        //remove old image if has changed
        $session = $this->getRequest()->getSession();
        if($object->getPath() != ($session->get(self::SESSION_IMAGE_SOURCE) . $object->getId()))
        {
            unlink($session->get(self::SESSION_IMAGE_SOURCE) . $object->getId());
        }
    }
    
}

