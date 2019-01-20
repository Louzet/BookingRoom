<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactAdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $choices_reache_me = [
            'Telephone' => 'Telephone',
            'Email' => 'Email',
        ];

        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'class' => 'wpcf7-form-control wpcf7-text wpcf7-validates-as-required',
                    'aria-required' => true,
                    'placeholder' => 'Votre nom',
                    'size' => 45,
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => [
                    'class' => 'wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email',
                    'aria-required' => true,
                    'placeholder' => 'Votre adresse email',
                    'size' => 45,
                ],
            ])
            ->add('telephone', TextType::class, [
                'label' => 'Numéro de téléphone',
                'attr' => [
                    'class' => 'wpcf7-form-control wpcf7-text wpcf7-tel wpcf7-validates-as-required wpcf7-validates-as-tel',
                    'aria-required' => true,
                    'placeholder' => 'Votre adresse numéro de téléphone',
                    'size' => 45,
                ],
            ])
            ->add('subject', TextareaType::class, [
                'attr' => [
                    'class' => 'wpcf7-form-control wpcf7-textarea',
                    'cols' => 40,
                    'rows' => 10,
                    'placeholder' => 'Entrez votre message ici',
                ],
            ])
            ->add('reache_me', ChoiceType::class, [
                'label_attr' => [
                    'class' => 'wpcf7-list-item-label ml-5',
                ],
                'label' => ' ',
                'choices' => $choices_reache_me,
                'expanded' => true,
                'preferred_choices' => $choices_reache_me['Telephone'],
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'wpcf7-form-control wpcf7-submit btn btn-block btn-success',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
            'attr' => [
                'class' => 'wpcf7-form',
            ],
        ]);
    }
}
