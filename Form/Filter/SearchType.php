<?php

namespace Galaxy\BackendBundle\Form\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SearchType extends AbstractType
{
    private $themes;

    public function setThemes($themes)
    {
        $this->themes = $themes;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('messageId', 'integer', array(
                    'required' => false,
                ))
                ->add('userId', 'integer', array(
                    'required' => false,
                ))
                ->add('theme', 'choice', array(
                    'required' => false,
                    'choices' => $this->themes,
                ))
                ->add('title', 'text', array(
                    'required' => false,
                ))
                ->add('visible', 'checkbox', array(
                    'required' => false,
                ))
                ->add('moderatorAccepted', 'checkbox', array(
                    'required' => false,
                ))
               ->add('age', 'choice', array(
                   'required' => false,
                    'choices' => array(
                        '12' => 'до 12',
                        '16' => 'до 16',
                        '18' => 'до 18',
                        '22' => 'до 22',
                        '23' => 'старше 22',
                    )))
                ->add('text', 'textarea', array(
                    'required' => false,
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Galaxy\BackendBundle\Entity\Filter\Search',
            'csrf_protection' => false,
        ));
    }

    public function getName()
    {
        return '';
    }

}
