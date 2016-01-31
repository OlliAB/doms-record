<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class TurnType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $last      = $options['data']->getGame()->getLastTurnNumber();
        $available = $options['data']->getGame()->getTurnsAvailable(10);
        $lastIndex = array_flip($available)[$last + 1];
        $new       = is_null($options['data']->getId());

        if ($new) {
            $builder
                ->add('number', ChoiceType::class, ['choices' => array_flip($available), 'choices_as_values' => true, 'data' => $lastIndex]);
        }

        $builder
            ->add('result')
            ->add('idea')
            ->add('plan')
            ->add('action')
        ;

        $builder->add(
            'privacy',
            ChoiceType::class,
            [
                'choices' => [
                    'None'  => 0,
                    'Link' => 1,
                ],
                'choices_as_values' => true,
            ]
        );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Turn'
        ));
    }
}