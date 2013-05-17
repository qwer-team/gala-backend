<?php

namespace Galaxy\BackendBundle\Form\Space;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SegmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('class')
            //->add('id')
            //->add('end')
            ->add('length', 'integer', array('attr' => array( 
                'class' => 'span3')))
            //->add('start')
            ->add('percent', 'integer', array('attr' => array( 
                'class' => 'span2',
                'append_input' => '%')))
        ;
    }

    public function getName()
    {
        return 'galaxy_BackendBundle_form_space_segmenttype';
    }
}
