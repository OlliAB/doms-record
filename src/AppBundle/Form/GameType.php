<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class GameType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('map')
            ->add(
            'age',
            ChoiceType::class,
            [
                'choices' => [
                    'Early'  => 1,
                    'Middle' => 2,
                    'Late'   => 3,
                ],
                'choices_as_values' => true,
                'mapped'            => false
            ]
        );

        $builder
            ->add('nation')
            ->add('pretender', null, ['attr' => ['class' => 'tinymce long']])
            ->add('serverLink', null, ['label' => 'Server link (f.i. llamaserver):', 'attr' => ['class' => 'long']])
            ->add('thread', null, ['label' => 'Game forum thread link:', 'attr' => ['class' => 'long']])
            ->add('planGeneral', null, ['attr' => ['class' => 'tinymce'], 'label' => 'Plan of general development:'])
            ->add('planResearch', null, ['attr' => ['class' => 'tinymce'], 'label' => 'Plan of research:'])
            ->add('winner', null, ['label' => 'Name of winner, if the game is over:']);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Game'
        ));
    }
}
