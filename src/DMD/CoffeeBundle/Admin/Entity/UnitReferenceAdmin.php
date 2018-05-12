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
 * Description of UnitReferenceAdmin
 *
 * @author princedominh <princedominh@gmail.com>
 */
class UnitReferenceAdmin extends Admin {
    
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->addIdentifier('material', null, array('label'=>'unit.label.material'))
                ->add('unitBase', null, array('label'=>'unit.label.base'))
                ->add('quantity', null, array('label'=>'unit.label.quantity'))
                ->add('unitReference', null, array('label'=>'unit.label.reference'))
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
            ->add('material', null, array('label'=>'unit.label.material'))
            ->add('unitBase', null, array('label'=>'unit.label.base'))
            ->add('unitReference', null, array('label'=>'unit.label.reference'))
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('material', 'sonata_type_model', array('label'=>'unit.label.material'))
            ->add('unitBase', 'sonata_type_model', array('label'=>'unit.label.base'))
            ->add('quantity', null, array('label'=>'unit.label.quantity'))
            ->add('unitReference', 'sonata_type_model', array('label'=>'unit.label.reference'))
        ;
    }
    
    protected function configureShowFields(\Sonata\AdminBundle\Show\ShowMapper $filter) {
        $filter
            ->add('material', 'sonata_type_model', array('label'=>'unit.label.material'))
            ->add('unitBase', 'sonata_type_model', array('label'=>'unit.label.base'))
            ->add('quantity', null, array('label'=>'unit.label.quantity'))
            ->add('unitBase', 'sonata_type_model', array('label'=>'unit.label.reference'))
        ;
        parent::configureShowFields($filter);
    }
}

