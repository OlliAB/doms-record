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
        $builder
            ->add('pretender', null, ['attr' => ['class' => 'tinymce']])
            ->add('planGeneral', null, ['attr' => ['class' => 'tinymce']])
            ->add('map')
            ->add('planResearch', null, ['attr' => ['class' => 'tinymce']])
            ->add('winner')
            ->add('serverLink')
            ->add('thread');

        $builder->add(
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
        )
            ->add('nation');
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
