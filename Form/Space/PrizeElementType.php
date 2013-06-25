<?php

namespace Galaxy\BackendBundle\Form\Space;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PrizeElementType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('name', 'text')
                ->add('available', 'integer')
                ->add('visible', 'integer')
                ->add('price', 'number')
                ->add('account', 'integer')
                ->add('movingVariant', 'integer')
                ->add('imgfile1', 'file', array("required" => false))
                ->add('imgfile2', 'file', array("required" => false))
                ->add('blocked', 'checkbox', array("required" => false))
        ;
    }

    public function getName()
    {
        return '';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => true,
        ));
    }

}