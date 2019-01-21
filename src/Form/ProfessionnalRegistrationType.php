<?php

namespace App\Form;

use App\Entity\Professionnal;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
            ->add('siren', IntegerType::class)
            ->add('address', TextareaType::class)
            ->add('codePostal', TextType::class)
            ->add('email', EmailType::class)
            ->add('password', PasswordType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Professionnal::class,
        ]);
    }
}
