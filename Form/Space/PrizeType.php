<?php

namespace Galaxy\BackendBundle\Form\Space;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PrizeType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('name', 'text', array(
                    'attr' => array(
                        'id' => 'inp'
                    )
                ))
                ->add('flipper', 'choice', array(
                    'choices' => array(
                        '1' => '1',
                        '2' => '2',
                        '3' => '3',
                        '4' => '4',
                        '5' => '5',
                    ),
                    'attr' => array(
                        'id' => 'flipInp'
                    )
                ))
                ->add('sms', 'text', array(
                    'attr' =>array(
                        'id' => 'inp'
                    )
                ))
                ->add('message1', 'textarea', array("required" => false,
                    'attr' => array(
                        'id' => 'txtArea'
                    )
                ))
                ->add('message2', 'textarea', array("required" => false,
                    'attr' => array(
                        'id' => 'txtArea'
                    )
                ))
                ->add('penalty', 'integer', array(
                    'attr' => array(
                        'id' => 'flipInp'
                    )
                ))
                ->add('imgfile1', 'file', array("required" => false))
                ->add('imgfile2', 'file', array("required" => false))
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