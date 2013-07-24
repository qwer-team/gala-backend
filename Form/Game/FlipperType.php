<?php

namespace Galaxy\BackendBundle\Form\Game;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FlipperType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array('required' => false))
            ->add('maxJump', 'integer', array('required' => false))
            ->add('journalDuration', 'integer', array('required' => false))
            ->add('rentDuration', 'integer', array('required' => false))
            ->add('rentCost', 'integer', array('required' => false))
            ->add('countRentMess', 'text', array('required' => false))
            ->add('activeAccLess', 'integer', array('required' => false))
            ->add('activeAccHint', 'text', array('required' => false))
            ->add('messageBuyHint', 'text', array('required' => false))
            ->add('radarCost', 'integer', array('required' => false))
            ->add('radarSpec', 'checkbox', array('required' => false))
            ->add('nextPointDistance', 'integer', array('required' => false))
            ->add('firstLeftBorder', 'integer', array('required' => false))
            ->add('secondLeftBorder', 'integer', array('required' => false))
            ->add('firstRightBorder', 'integer', array('required' => false))
            ->add('secondRightBorder', 'integer', array('required' => false))
            ->add('distanceHint', 'text', array('required' => false))
            ->add('searchZoneCost', 'integer', array('required' => false))
            ->add('searchZoneSpec', 'checkbox', array('required' => false))
            ->add('leftBorderSearchX', 'integer', array('required' => false))
            ->add('rightBorderSearchX', 'integer', array('required' => false))
            ->add('deltaSearchX', 'integer', array('required' => false))
            ->add('leftBorderSearchY', 'integer', array('required' => false))
            ->add('rightBorderSearchY', 'integer', array('required' => false))
            ->add('deltaSearchY', 'integer', array('required' => false))
            ->add('leftBorderSearchZ', 'integer', array('required' => false))
            ->add('rightBorderSearchZ', 'integer', array('required' => false))
            ->add('deltaSearchZ', 'integer', array('required' => false))
            ->add('incLeftSearchRadius', 'integer', array('required' => false))
            ->add('incRightSearchRadius', 'integer', array('required' => false))
            ->add('firstZoneDuration1', 'integer', array('required' => false))
            ->add('firstZoneCost1', 'integer', array('required' => false))
            ->add('firstZoneSpec1', 'checkbox', array('required' => false))
            ->add('firstZoneDuration2', 'integer', array('required' => false))
            ->add('firstZoneCost2', 'integer', array('required' => false))
            ->add('firstZoneSpec2', 'checkbox', array('required' => false))
            ->add('firstZoneDuration3', 'integer', array('required' => false))
            ->add('firstZoneCost3', 'integer', array('required' => false))
            ->add('firstZoneSpec3', 'checkbox', array('required' => false))
            ->add('firstZoneDuration4', 'integer', array('required' => false))
            ->add('firstZoneCost4', 'integer', array('required' => false))
            ->add('firstZoneSpec4', 'checkbox', array('required' => false))
            ->add('secondZoneDuration1', 'integer', array('required' => false))
            ->add('secondZoneCost1', 'integer', array('required' => false))
            ->add('secondZoneSpec1', 'checkbox', array('required' => false))
            ->add('secondZoneDuration2', 'integer', array('required' => false))
            ->add('secondZoneCost2', 'integer', array('required' => false))
            ->add('secondZoneSpec2', 'checkbox', array('required' => false))
            ->add('secondZoneDuration3', 'integer', array('required' => false))
            ->add('secondZoneCost3', 'integer', array('required' => false))
            ->add('secondZoneSpec3', 'checkbox', array('required' => false))
            ->add('secondZoneDuration4', 'integer', array('required' => false))
            ->add('secondZoneCost4', 'integer', array('required' => false))
            ->add('secondZoneSpec4', 'checkbox', array('required' => false))
            ->add('costJump', 'integer', array('required' => false))
            ->add('impossibleJumpHint', 'text', array('required' => false))
            ->add('paymentFromDeposit', 'checkbox', array('required' => false))
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
