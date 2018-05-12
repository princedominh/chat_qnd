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
 * Description of TableAdmin
 *
 * @author princedominh <princedominh@gmail.com>
 */
class TableAdmin extends Admin {
    
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->addIdentifier('name', null, array('label'=>'table.label.name'))
                ->add('area', null, array('label'=>'table.label.area'))
                ->add('created_at', 'date', array('label'=>'table.label.created_at'))
                ->add('description', null , array(
                    'label'=>'table.label.description',
                    'template'=>'ApplicationSonataAdminBundle:Admin:list_content.html.twig',
                    ))
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
            ->add('name', null, array('label'=>'table.label.name'))
            ->add('area', null, array('label'=>'table.label.area'))
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
                ->add('name', null, array('label'=>'table.label.name'))
                ->add('area', 'sonata_type_model', array('label'=>'table.label.area'))
                ->add('description', null, array('label'=>'table.label.description'))
            ->end()
        ;
    }
    
    protected function configureShowFields(\Sonata\AdminBundle\Show\ShowMapper $filter) {
        $filter
            ->add('name', null, array('label'=>'table.label.name'))
            ->add('area', null, array('label'=>'table.label.area'))
            ->add('description', null, array('label'=>'table.label.description'))
        ;
        parent::configureShowFields($filter);
    }

}

