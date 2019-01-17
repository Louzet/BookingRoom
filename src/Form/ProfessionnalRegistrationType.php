<?php

namespace App\Form;

use App\Entity\Professionnal;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfessionnalRegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('entreprise', TextType::class, [
                'required' => true,
                'label' => "Nom d'Entreprise",
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Nom de Votre Entreprise',
                ],
            ])
            ->add('siren')
            ->add('address')
            ->add('codePostal')
            ->add('email')
            ->add('password')

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Professionnal::class,
        ]);
    }
}
