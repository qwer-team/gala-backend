<?php

namespace Galaxy\BackendBundle\Form\Space;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SegmentType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $lengthOpts = array(
            'attr' => array(
                'class' => 'span2',
            )
        );
        $percentOpts = array(
            'attr' => array(
                'class' => 'span2',
            )
        );
        $builder
        ->add('length', 'integer', $lengthOpts)
        ->add('percent', 'field', $percentOpts)
        ;
    }

    public function getName()
    {
        return '';
    }

}
