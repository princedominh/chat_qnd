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
 * Description of RecipeAdmin
 *
 * @author princedominh <princedominh@gmail.com>
 */
class RecipeAdmin extends Admin {
    
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->addIdentifier('item', null, array('label'=>'unit.label.item'))
                ->add('material', null, array('label'=>'unit.label.material'))
                ->add('unit', null, array('label'=>'unit.label.base'))
                ->add('quantity', null, array('label'=>'unit.label.quantity'))
                ->add('current_price', null, array('label'=>'item.label.current_price'))
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
            ->add('item', null, array('label'=>'unit.label.item'))
            ->add('material', null, array('label'=>'unit.label.material'))
            ->add('unit', null, array('label'=>'unit.label.base'))
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('material', 'sonata_type_model', array('label'=>'unit.label.material'))
            ->add('unit', 'sonata_type_model', array('label'=>'unit.label.unit'))
            ->add('quantity', null, array('label'=>'unit.label.quantity'))
            ->add('prices', 'sonata_type_collection', 
                    array('type_options' => array('delete' => true),
                        'required'=>false,
                        'by_reference'=>true),
                    array( 
                        'edit' => 'inline',
                        'inline' => 'table',
                        'sortable' => 'position',
                    ))
        ;
    }
    
    protected function configureShowFields(\Sonata\AdminBundle\Show\ShowMapper $filter) {
        $filter
            ->add('item', null, array('label'=>'unit.label.item'))
            ->add('material', 'sonata_type_model', array('label'=>'unit.label.material'))
            ->add('unit', 'sonata_type_model', array('label'=>'unit.label.unit'))
            ->add('quantity', null, array('label'=>'unit.label.quantity'))
        ;
        parent::configureShowFields($filter);
    }
    
    public function prePersist($object) {
        $prices = $object->getPrices();
        if (count ($prices) > 0) {
            $newestUsed = $prices[0]->getUsedAt(); //used for update current price
            $object->setCurrentPrice($prices[0]->getPrice());
            foreach ($prices as $price) {
                $price->setRecipe($object);

                //update current price
                if (($price->getUsedAt() > $newestUsed)) {
                    $newestUsed = $price->getUsedAt();
                    $object->setCurrentPrice($price->getPrice());
                }
            }
        }
        parent::prePersist($object);
    }
    
    public function preUpdate($object) {
        $prices = $object->getPrices();
        
        if (count ($prices) > 0) {
            $newestUsed = $prices[0]->getUsedAt(); //used for update current price
            $object->setCurrentPrice($prices[0]->getPrice());
            foreach ($prices as $price) {
                $price->setRecipe($object);
                
                //update current price
                if (($price->getUsedAt() > $newestUsed)) {
                    $newestUsed = $price->getUsedAt();
                    $object->setCurrentPrice($price->getPrice());
                }
            }
        }
        
        parent::preUpdate($object);
    }
        
}

