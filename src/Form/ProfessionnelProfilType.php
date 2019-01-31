<?php

namespace App\Form;

use App\Entity\Professionnal;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfessionnelProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('entreprise', TextType::class, [
                'label' => 'Nom entreprise',
            ])
            ->add('siren', TextType::class, [
                'label' => 'N° Siren',
                'attr' => [
                    'class' => 'disabled',
                    'readonly' => true,
                ],
            ])
            ->add('address', TextType::class, [
                'label' => 'Domicilié',
            ])
            ->add('codePostal', TextType::class, [
                'label' => 'Code postal',
            ])
            ->add('email', EmailType::class, [
                'label' => 'Votre email',
                'attr' => [
                    'class' => 'disabled',
                    'readonly' => true,
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Professionnal::class,
        ]);
    }
}
