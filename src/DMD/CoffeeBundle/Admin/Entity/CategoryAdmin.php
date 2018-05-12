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
 * Description of CategoryAdmin
 *
 * @author princedominh <princedominh@gmail.com>
 */
class CategoryAdmin extends Admin {
    
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->addIdentifier('name', null, array('label'=>'category.label.name'))
                ->addIdentifier('alias', null, array('label'=>'category.label.alias'))
                ->add('parent', null, array('label'=>'category.label.parent'))
//                ->add('message', null , array(
//                    'label'=>'contact.label.message',
//                    'template'=>'ApplicationSonataAdminBundle:Admin:list_content.html.twig',
//                    ))
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
            ->add('name')
            ->add('parent')
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', null, array('label'=>'category.label.name'))
            ->add('alias', null, array('label'=>'category.label.alias'))
            ->add('parent', null, array('label'=>'category.label.parent'))
        ;
    }
    
    protected function configureShowFields(\Sonata\AdminBundle\Show\ShowMapper $filter) {
        $filter
            ->add('name', null, array('label'=>'category.label.name'))
            ->add('alias', null, array('label'=>'category.label.alias'))
            ->add('parent', null, array('label'=>'category.label.parent'))
        ;
        parent::configureShowFields($filter);
    }

}

