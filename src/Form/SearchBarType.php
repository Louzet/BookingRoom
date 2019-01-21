<?php

namespace App\Form;

use App\Entity\Search_bar;
use App\Entity\TypeOfRoom;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchBarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('evenement', EntityType::class, [
                'class' => TypeOfRoom::class,
                'choice_label' => 'title',
                'placeholder' => ' ',
            ])
            ->add('date_debut')
            ->add('date_fin')
            ->add('place', ChoiceType::class)
            ->add('Submit', SubmitType::class, [
                'label' => 'Rechercher',
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Search_bar::class,
            'method' => 'GET',
            'attr' => [
                'class' => 'form-inline',
            ],
            'csrf_protection' => false,
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
