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
                    'attr' => array(
                        'id' => 'messageId',
                        'placeholder' => 'id'
                    )
                ))
                ->add('userId', 'integer', array(
                    'required' => false,
                    'attr' => array(
                        'id' => 'userId',
                        'placeholder' => 'User'
                    )
                ))
                ->add('theme', 'choice', array(
                    'required' => false,
                    'choices' => $this->themes,
                    'empty_value' => 'Тема',
                    'attr' => array(
                        'id' => 'theme'
                    )
                ))
                ->add('title', 'text', array(
                    'required' => false,
                    'attr' => array(
                        'id' => 'title',
                        'placeholder' => 'Название'
                    )
                ))
                ->add('visible', 'choice', array(
                    'required' => false,
                    'choices' => array(
                        '0' => 'Невидим',
                        '1' => 'Видим',),
                ))
                ->add('moderatorAccepted', 'choice', array(
                    'required' => false,
                    'empty_value' => 'Не/Принято',
                    'choices' => array(
                        '0' => 'Не принято',
                        '1' => 'Принято',
                    ),
                    'attr' => array(
                        'id' => 'moderator'
                    )
                ))
               ->add('age', 'choice', array(
                   'required' => false,
                   'empty_value' => 'Возраст',
                   'empty_data' => null,
                   'attr' => array(
                       'id' => 'age'
                   ),
                    'choices' => array(
                        '12' => 'до 12',
                        '16' => 'до 16',
                        '18' => 'до 18',
                        '22' => 'до 22',
                        '23' => 'старше 22',
                    )))
                ->add('text', 'text', array(
                    'required' => false,
                    'attr' => array(
                        'id' => 'text',
                        'placeholder' => 'Текст'
                    )
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
