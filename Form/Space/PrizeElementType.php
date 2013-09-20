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
                ->add('name', 'text', array(
                    'attr' => array(
                        'style' => 'width:350px'
                    )
                ))
                ->add('available', 'integer', array(
                    'attr' => array(
                        'id' => 'flipInp'
                    )
                ))
                ->add('visible', 'integer', array(
                    'attr' => array(
                        'id' => 'flipInp'
                    )
                ))
                ->add('price', 'number', array(
                    'attr' => array(
                        'id' => 'flipInp'
                    )
                ))
                ->add('account', 'choice', array(
                    'choices' => array(
                        '1' => 'Активный',
                        '3' => 'Депозитный',
                    ),
                    'attr' => array(
                        'id' => 'inp'
                    )
                ))
                ->add('movingVariant',  'choice', array(
                    'choices' => array(
                        '1' => '1',
                        '2' => '2',
                        '3' => '3',
                    ),
                    'attr' => array(
                        'style' => 'width:50px'
                    )
                ))
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