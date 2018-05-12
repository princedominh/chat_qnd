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
 * Description of ProductPriceAdmin
 *
 * @author princedominh <princedominh@gmail.com>
 */
class RecipePriceAdmin extends Admin {
    
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->addIdentifier('price', null, array('label'=>'item.label.price'))
                ->add('recipe', null, array('label'=>'item.label.recipe'))
                ->add('_action', 'actions', array(
                        'actions' => array(
                        'edit' => array(),
                        'delete' => array(),
                        )));
        parent::configureListFields($listMapper);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
                ->add('price')
                ->add('recipe')
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
                ->add('price', null, array('required'=>true, 'label'=>'item.label.price'))
                ->add('usedAt', 'sonata_type_datetime_picker', array('required'=>true,'format'=>'dd/MM/yyyy HH:mm:ss','label'=>'item.label.used_at'))
        ;
    }
    
    protected function configureShowFields(\Sonata\AdminBundle\Show\ShowMapper $filter) {
        $filter
                ->add('price')
                ->add('recipe')
        ;
        parent::configureShowFields($filter);
    }

}

