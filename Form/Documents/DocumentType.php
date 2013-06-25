<?php

namespace Galaxy\BackendBundle\Form\Documents;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DocumentType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $choices = array(
            1 => "Активный счет",
            2 => "Безопасный счет",
            3 => "Депозитны счет"
        );
        $builder
                ->add('OA1', 'integer', array('label' => 'Ид пользователя', 'required' => true))
                ->add('account', 'choice', array('choices' => $choices, 'label' => 'Счет', 'required' => true))
                ->add('text1', 'textarea', array( 'label' => 'Причина', 'required' => true))
                ->add('summa1', 'number', array('required' => true))
        ;
    }

    public function getName()
    {
        return '';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
        ));
    }

}