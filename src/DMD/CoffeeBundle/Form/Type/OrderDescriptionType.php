<?php

namespace DMD\CoffeeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Description of OrderDescriptionType
 *
 * @author princedominh <princedominh@gmail.com>
 */
class OrderDescriptionType extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('id', 'hidden');
        $builder->add('description', 'textarea', array('label' => 'Mô tả','attr'=>array(
            'class'=>'cf-order-description tinymce',
        )));
    }

    public function getName()
    {
        return 'order';
    }
}

