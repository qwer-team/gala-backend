<?php

namespace Galaxy\BackendBundle\Form\Space;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TypeCoordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $opts = array(
            'attr' => array(
                'class' => 'span1',
            )
        );
        $builder
            ->add('id', 'hidden')
            ->add('a', 'integer', $opts)
            ->add('b', 'integer', $opts)
            ->add('c', 'integer', $opts)
            ->add('delta1', 'integer', $opts)
         ;
    }

    public function getName()
    {
        return '';
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection'   => false,
        ));
    }
}