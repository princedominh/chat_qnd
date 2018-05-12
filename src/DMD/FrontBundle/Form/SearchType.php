<?php

namespace DMD\FrontBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Description of SearchType
 *
 * @author princedominh <princedominh@gmail.com>
 */
class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('key', 'text', array(
                'label' => 'search.label.keyword',
                'required' => false,
            ))
        ;
    }
    
    public function getName() {
        return 'search';
    }
}

