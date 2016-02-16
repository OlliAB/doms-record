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
        $builder->add('map', null, ['label' => 'Map:'])
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
                'mapped'            => false,
                'label' => 'Age:'
            ]
        );

        $builder
            ->add('nation', null, ['label' => 'Nation:'])
            ->add('pretender', null, ['attr' => ['class' => 'tinymce long', 'placeholder' => 'Gorgon 6N6E'], 'label' => 'Pretender and scales description:'])
            ->add('serverLink', null, ['label' => 'Server (llamaserver?) link:',
                                       'attr' => ['class' => 'long',
                                                  'placeholder' => 'http://www.llamaserver.net/gameinfo.cgi?game=Sauron']])
            ->add('thread', null, ['label' => 'Game forum thread link:',
                                   'attr' => ['class' => 'long',
                                              'placeholder' => 'http://www.desura.com/games/dominions-4-thrones-of-ascensions/forum/thread/new-ea-game6/page/2#1076080']])
            ->add('planGeneral', null, ['attr' => ['class' => 'tinymce'], 'label' => 'Plan of general development:'])
            ->add('planResearch', null, ['attr' => ['class' => 'tinymce'], 'label' => 'Plan of research:'])
            ->add('winner', null, ['label' => 'Name of winner, if the game is over:', 'attr' => ['placeholder' => 'It is me']]);
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
