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
 * Description of ItemAdmin
 *
 * @author princedominh <princedominh@gmail.com>
 */
class ItemAdmin extends Admin {
    
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->addIdentifier('name', null, array('label'=>'item.label.name'))
                ->add('category', null, array('label'=>'item.label.category'))
                ->add('current_price', null, array('label'=>'item.label.current_price'))
                ->add('current_cost', null, array('label'=>'item.label.current_cost','help'=>'Giá ước tính'))
                ->add('description', null , array(
                    'label'=>'item.label.description',
                    'template'=>'ApplicationSonataAdminBundle:Admin:list_content.html.twig',
                    ))
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
            ->add('name')
            ->add('category')
            ->add('is_star')
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
                ->add('name')
//                ->add('alias')
                ->add('category', 'sonata_type_model')
                ->add('images', 'sonata_type_collection', 
                        array('type_options' => array('delete' => true),
                            'required'=>false,
                            'by_reference'=>true),
                        array( 
                            'edit' => 'inline',
                            'inline' => 'table',
                            'sortable' => 'position',
                        ))
                ->add('prices', 'sonata_type_collection', 
                        array('type_options' => array('delete' => true),
                            'required'=>false,
                            'by_reference'=>true),
                        array( 
                            'edit' => 'inline',
                            'inline' => 'table',
                            'sortable' => 'position',
                        ))
//                ->add('current_price')
                ->add('current_cost', 'integer', array('label'=>'item.label.current_cost','help'=>'Giá gốc tính. VNĐ'))
                ->add('description')
                ->add('unit')
                ->add('is_star', null, array('required'=>false))
            ->end()
            ->with('Recipe')
                ->add('recipes', 'sonata_type_collection', 
                        array('type_options' => array('delete' => true),
                            'required'=>false,
                            'by_reference'=>true),
                        array( 
                            'edit' => 'inline',
                            'inline' => 'table',
                            'sortable' => 'position',
                        ))
            ->end()
        ;
    }
    
    protected function configureShowFields(\Sonata\AdminBundle\Show\ShowMapper $filter) {
        $filter
            ->add('name')
            ->add('alias')
            ->add('category')
            ->add('description')
            ->add('is_star')
        ;
        parent::configureShowFields($filter);
    }

    public function prePersist($object) {
        $images = $object->getImages();
        if (count ($images) > 0) {
            foreach ($images as $image) {
                $image->setItem($object);
            }
        }
        $prices = $object->getPrices();
        if (count ($prices) > 0) {
            $newestUsed = $prices[0]->getUsedAt(); //used for update current price
            $object->setCurrentPrice($prices[0]->getPrice());
            foreach ($prices as $price) {
                $price->setItem($object);

                //update current price
                if (($price->getUsedAt() > $newestUsed)) {
                    $newestUsed = $price->getUsedAt();
                    $object->setCurrentPrice($price->getPrice());
                }
            }
        }
        $recipes = $object->getRecipes();
        if (count ($recipes) > 0) {
            foreach ($recipes as $recipe) {
                $recipe->setItem($object);
                $prices = $recipe->getPrices();
                if(count($prices) > 0) {
                    $newestUsed = $prices[0]->getUsedAt(); //used for update current price
                    $recipe->setCurrentPrice($prices[0]->getPrice());
                    foreach ($prices as $price) {
                        $price->setRecipe($recipe);

                        //update current price
                        if (($price->getUsedAt() > $newestUsed)) {
                            $newestUsed = $price->getUsedAt();
                            $recipe->setCurrentPrice($price->getPrice());
                        }
                    }
                }
            }
        }
        parent::prePersist($object);
    }
    
    public function preUpdate($object) {
        $images = $object->getImages();
        if (count ($images) > 0) {
            foreach ($images as $image) {
                $image->setItem($object);
            }
        }
        $prices = $object->getPrices();
        
        if (count ($prices) > 0) {
            $newestUsed = $prices[0]->getUsedAt(); //used for update current price
            $object->setCurrentPrice($prices[0]->getPrice());
            foreach ($prices as $price) {
                $price->setItem($object);
                
                //update current price
                if (($price->getUsedAt() > $newestUsed)) {
                    $newestUsed = $price->getUsedAt();
                    $object->setCurrentPrice($price->getPrice());
                }
            }
        }
        $recipes = $object->getRecipes();
        if (count ($recipes) > 0) {
            foreach ($recipes as $recipe) {
                $recipe->setItem($object);
                $prices = $recipe->getPrices();
                if(count($prices) > 0) {
                    $newestUsed = $prices[0]->getUsedAt(); //used for update current price
                    $recipe->setCurrentPrice($prices[0]->getPrice());
                    foreach ($prices as $price) {
                        $price->setRecipe($recipe);

                        //update current price
                        if (($price->getUsedAt() > $newestUsed)) {
                            $newestUsed = $price->getUsedAt();
                            $recipe->setCurrentPrice($price->getPrice());
                        }
                    }
                }
            }
        }
        
        parent::preUpdate($object);
    }
    
//    public function postUpdate($object) {
//        $this->postPersist($object);
//    }
}

