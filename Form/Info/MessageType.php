<?php

namespace Galaxy\BackendBundle\Form\Info;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('incPoints', 'integer', array(
                'required' => false,
            ))
            ->add('incPointsActv', 'checkbox', array(
                'required' => false,
                'data' => false,
            ))
            ->add('incPointsProc', 'checkbox', array(
                'required' => false,
                'data' => false,
            ))
            ->add('incPointsMess', 'textarea', array(
                'required' => false,
            ))
            ->add('incOwnElem', 'integer', array(
                'required' => false,
            ))
            ->add('incOwnElemActv', 'checkbox', array(
                'required' => false,
                'data' => false,
            ))
            ->add('incOwnElemMess', 'textarea', array(
                'required' => false,
            ))
            ->add('incDurationMinElem', 'integer', array(
                'required' => false,
            ))
            ->add('incDurationMinElemActv', 'checkbox', array(
                'required' => false,
                'data' => false,
            ))
            ->add('incDurationMinElemMess', 'textarea', array(
                'required' => false,
            ))
            ->add('incFlipAmount', 'integer', array(
                'required' => false,
            ))
            ->add('incFlipAmountActv', 'checkbox', array(
                'required' => false,
                'data' => false,
            ))
            ->add('incFlipAmountMess', 'textarea', array(
                'required' => false,
            ))
            ->add('superjumpAmount', 'integer', array(
                'required' => false,
            ))
            ->add('superjumpAmountActv', 'checkbox', array(
                'required' => false,
                'data' => false,
            ))
            ->add('superjumpAmountMess', 'textarea', array(
                'required' => false,
            ))
            ->add('incDurationAllElem', 'integer', array(
                'required' => false,
            ))
            ->add('incDurationAllElemActv', 'checkbox', array(
                'required' => false,
                'data' => false,
            ))
            ->add('incDurationAllElemMess', 'textarea', array(
                'required' => false,
            ))
            ->add('decPoints', 'integer', array(
                'required' => false,
            ))
            ->add('decPointsActv', 'checkbox', array(
                'required' => false,
                'data' => false,
            ))
            ->add('decPointsProc', 'checkbox', array(
                'required' => false,
                'data' => false,
            ))
            ->add('decPointsMess', 'textarea', array(
                'required' => false,
            ))
            ->add('decFlipAmount', 'integer', array(
                'required' => false,
            ))
            ->add('decFlipAmountActv', 'checkbox', array(
                'required' => false,
                'data' => false,
            ))
            ->add('decFlipAmountMess', 'textarea', array(
                'required' => false,
            ))
            ->add('superjumpCancelActv', 'checkbox', array(
                'required' => false,
                'data' => false,
            ))
            ->add('superjumpCancelMess', 'textarea', array(
                'required' => false,
            ))
            ->add('activeCancelActv', 'checkbox', array(
                'required' => false,
                'data' => false,
            ))
            ->add('activeCancelMess', 'textarea', array(
                'required' => false,
            ))
            ->add('firstFlipperActv', 'checkbox', array(
                'required' => false,
                'data' => false,
            ))
            ->add('firstFlipperMess', 'textarea', array(
                'required' => false,
            ))
            ->add('blackPointActv', 'checkbox', array(
                'required' => false,
                'data' => false,
            ))
            ->add('blackPointMess', 'textarea', array(
                'required' => false,
            ))
            ->add('delElemGroupActv', 'checkbox', array(
                'required' => false,
                'data' => false,
            ))
            ->add('delElemGroupMess', 'textarea', array(
                'required' => false,
            ))
            ->add('decDurationAllElem', 'integer', array(
                'required' => false,
            ))
            ->add('decDurationAllElemActv', 'checkbox', array(
                'required' => false,
                'data' => false,
            ))
            ->add('decDurationAllElemMess', 'textarea', array(
                'required' => false,
            ))
            ->add('userId', 'integer', array(
                'required' => false,
            ))
            ->add('title', 'text')
            ->add('visible', 'checkbox', array(
                'required' => false,
                'data' => false,
            ))
            ->add('moderatorAccepted', 'checkbox', array(
                'required' => false,
                'data' => false,
            ))
            ->add('theme', 'text')
            ->add('age', 'integer', array(
                'required' => false,
            ))
            ->add('text', 'text')
            ->add('image', 'text', array(
                'required' => false,
            ))
            ->add('jumpsToQuestion', 'integer', array(
                'required' => false,
            ))
            ->add('seconds', 'integer', array(
                'required' => false,
            ))
            ->add('questions', 'integer', array(
                'required' => false,
            ))
            ->add('rightAnswer', 'integer', array(
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
