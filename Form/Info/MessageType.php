<?php

namespace Galaxy\BackendBundle\Form\Info;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MessageType extends AbstractType
{

    private $themes;

    public function setThemes($themes)
    {
        $this->themes = $themes;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
                ->add('incPoints', 'integer', array(
                    'required' => false,
                    'attr' => array(
                        'id' => 'messageId'
                    )
                ))
                ->add('messageId', 'integer', array(
                    'required' => false,
                    'attr' => array(
                        'id' => 'messageId' 
                    )
                ))
                ->add('question', 'textarea')
                ->add('answers', 'collection', array(
                    'type' => new AnswerType())
                )
                ->add('rightAnswer', 'choice', array(
                    'choices' => array(
                        '1' => '1',
                        '2' => '2',
                        '3' => '3',
                        '4' => '4',
                        '5' => '5',
                    )
                ))
                ->add('imgfile', 'file', array("required" => false,
                        ))
                ->add('imageDelete', 'checkbox', array(
                    'required' => false,
                ))
                ->add('incPointsActv', 'checkbox', array(
                    'required' => false,
                ))
                ->add('incPointsProc', 'checkbox', array(
                    'required' => false,
                ))
                ->add('incPointsMess', 'textarea', array(
                    'required' => false,
                    'attr' => array(
                        'class' => 'width'
                    )
                ))
                ->add('incOwnElem', 'integer', array(
                    'required' => false,
                    'attr' => array(
                        'id' => 'messageId'
                    )
                ))
                ->add('incOwnElemActv', 'checkbox', array(
                    'required' => false,
                ))
                ->add('incOwnElemMess', 'textarea', array(
                    'required' => false,
                    'attr' => array(
                        'class' => 'width'
                    )
                    
                ))
                ->add('incDurationMinElem', 'integer', array(
                    'required' => false,
                    'attr' => array(
                        'id' => 'messageId'
                    )
                ))
                ->add('incDurationMinElemActv', 'checkbox', array(
                    'required' => false,
                ))
                ->add('incDurationMinElemMess', 'textarea', array(
                    'required' => false,
                    'attr' => array(
                        'class' => 'width'
                    )
                ))
                ->add('incFlipAmount', 'integer', array(
                    'required' => false,
                    'attr' => array(
                        'id' => 'messageId'
                    )
                ))
                ->add('incFlipAmountActv', 'checkbox', array(
                    'required' => false,
                ))
                ->add('incFlipAmountMess', 'textarea', array(
                    'required' => false,
                    'attr' => array(
                        'class' => 'width'
                    )
                ))
                ->add('superjumpAmount', 'integer', array(
                    'required' => false,
                    'attr' => array(
                        'id' => 'messageId'
                    )
                ))
                ->add('superjumpAmountActv', 'checkbox', array(
                    'required' => false,
                ))
                ->add('superjumpAmountMess', 'textarea', array(
                    'required' => false,
                    'attr' => array(
                        'class' => 'width'
                    )
                ))
                ->add('incDurationAllElem', 'integer', array(
                    'required' => false,
                    'attr' => array(
                        'id' => 'messageId'
                    )
                ))
                ->add('incDurationAllElemActv', 'checkbox', array(
                    'required' => false,
                ))
                ->add('incDurationAllElemMess', 'textarea', array(
                    'required' => false,
                    'attr' => array(
                        'class' => 'width'
                    )
                ))
                ->add('decPoints', 'integer', array(
                    'required' => false,
                    'attr' => array(
                        'id' => 'messageId'
                    )
                ))
                ->add('decPointsActv', 'checkbox', array(
                    'required' => false,
                ))
                ->add('decPointsProc', 'checkbox', array(
                    'required' => false,
                ))
                ->add('decPointsMess', 'textarea', array(
                    'required' => false,
                    'attr' => array(
                        'class' => 'width'
                    )
                ))
                ->add('decFlipAmount', 'integer', array(
                    'required' => false,
                    'attr' => array(
                        'id' => 'messageId'
                    )
                ))
                ->add('decFlipAmountActv', 'checkbox', array(
                    'required' => false,
                ))
                ->add('decFlipAmountMess', 'textarea', array(
                    'required' => false,
                    'attr' => array(
                        'class' => 'width'
                    )
                ))
                ->add('superjumpCancelActv', 'checkbox', array(
                    'required' => false,
                ))
                ->add('superjumpCancelMess', 'textarea', array(
                    'required' => false,
                    'attr' => array(
                        'class' => 'width'
                    )
                ))
                ->add('activeCancelActv', 'checkbox', array(
                    'required' => false,
                ))
                ->add('activeCancelMess', 'textarea', array(
                    'required' => false,
                    'attr' => array(
                        'class' => 'width'
                    )
                ))
                ->add('firstFlipperActv', 'checkbox', array(
                    'required' => false,
                ))
                ->add('firstFlipperMess', 'textarea', array(
                    'required' => false,
                    'attr' => array(
                        'class' => 'width'
                    )
                ))
                ->add('blackPointActv', 'checkbox', array(
                    'required' => false,
                ))
                ->add('blackPointMess', 'textarea', array(
                    'required' => false,
                    'attr' => array(
                        'class' => 'width'
                    )
                ))
                ->add('delElemGroupActv', 'checkbox', array(
                    'required' => false,
                ))
                ->add('delElemGroupMess', 'textarea', array(
                    'required' => false,
                    'attr' => array(
                        'class' => 'width'
                    )
                ))
                ->add('decDurationAllElem', 'integer', array(
                    'required' => false,
                    'attr' => array(
                        'id' => 'messageId'
                    )
                ))
                ->add('decDurationAllElemActv', 'checkbox', array(
                    'required' => false,
                ))
                ->add('decDurationAllElemMess', 'textarea', array(
                    'required' => false,
                    'attr' => array(
                        'class' => 'width'
                    )
                ))
                ->add('userId', 'integer', array(
                    'required' => false,
                ))
                ->add('title', 'text', array(
                    'required' => false,
                    'attr' => array(
                        'id' => 'title'
                    )
                ) )
                ->add('visible', 'checkbox', array(
                    'required' => false,
                    'attr' => array(
                        'id' => 'visible'
                    )
                ))
                ->add('moderatorAccepted', 'checkbox', array(
                    'required' => false,
                ))
                ->add('theme', 'choice', array(
                    'required' => false,
                    'choices' => $this->themes,
                    'attr' => array(
                        'id' => 'theme'
                    )
                ))
                ->add('age', 'choice', array(
                    'required' => false,
                    'choices' => array(
                        '12' => 'до 12',
                        '16' => 'до 16',
                        '18' => 'до 18',
                        '22' => 'до 22',
                        '23' => 'старше 22',
                    ),
                    'attr' => array(
                        'id' => 'age'
                    )
                ))
                ->add('text', 'textarea', array(
                    'attr' => array('class' => 'tinymce'),
                    'required' => false,
                ))
                ->add('jumpsToQuestion', 'integer', array(
                    'required' => false,
                    'attr' => array(
                        'id' => 'messageId'
                    )
                ))
                ->add('seconds', 'integer', array(
                    'required' => false,
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
        ));
    }

    public function getName()
    {
        return '';
    }

}
