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
 * Description of InventoryReceivingVoucherAdmin
 *
 * @author princedominh <princedominh@gmail.com>
 */
class InventoryReceivingVoucherAdmin extends Admin {
    
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->addIdentifier('material', null, array('label'=>'inventory.label.material'))
                ->add('quantity', null, array('label'=>'inventory.label.quantity'))
                ->add('unit', null, array('label'=>'inventory.label.unit'))
                ->add('price', null, array('label'=>'inventory.label.price'))
                ->add('user', null, array('label'=>'inventory.label.user'))
                ->add('created_at', 'datetime', array('label'=>'inventory.label.created_at'))
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
            ->add('material', null, array('label'=>'inventory.label.material'))
            ->add('quantity', null, array('label'=>'inventory.label.quantity'))
            ->add('unit', null, array('label'=>'inventory.label.unit'))
            ->add('price', null, array('label'=>'inventory.label.price'))
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('material', 'sonata_type_model', array('label'=>'inventory.label.material'))
            ->add('quantity', null, array('label'=>'inventory.label.quantity','help' => 'Số nguyên hoặc thập phân (ví dụ: 8, 9.5, 10.25)'))
            ->add('unit', 'sonata_type_model', array('label'=>'inventory.label.unit'))
            ->add('price', null, array('label'=>'inventory.label.price','help' => 'VNĐ, số nguyên'))
        ;
    }
    
    protected function configureShowFields(\Sonata\AdminBundle\Show\ShowMapper $filter) {
        $filter
            ->add('material', 'sonata_type_model', array('label'=>'inventory.label.material'))
            ->add('quantity', null, array('label'=>'inventory.label.quantity'))
            ->add('unit', 'sonata_type_model', array('label'=>'inventory.label.unit'))
            ->add('price', null, array('label'=>'inventory.label.price'))
        ;
        parent::configureShowFields($filter);
    }
    
    public function prePersist($object) {
        $user = $this->getConfigurationPool()->getContainer()->get('security.context')->getToken()->getUser();
        $object->setUser($user);
        parent::prePersist($object);
    }
    public function preUpdate($object) {
        $user = $this->getConfigurationPool()->getContainer()->get('security.context')->getToken()->getUser();
        $object->setUser($user);
        parent::preUpdate($object);
    }
}

