<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserLoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add($options['username_parameter'], EmailType::class, [
                'required' => true,
                'label' => 'Email',
            ])
            ->add($options['password_parameter'], PasswordType::class, [
                'required' => true,
                'label' => 'Mot de passe',
                'attr' => [
                    'placeholder' => '******',
                ],
            ])
            ->add('_remember_me', CheckboxType::class, [
                'label' => 'Se souvenir de moi',
                'required' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Connexion',
                'attr' => [
                    'class' => 'btn-primary btn-block',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
                'username_parameter' => 'email',
                'password_parameter' => 'password',
                'data_class' => null,
                'csrf_field_name' => '_login_csrf',
                'csrf_token_id' => 'authenticate',
                'remember_me' => false,
                'translation_domain' => false,
            ])
        ;
    }

    public function getBlockPrefix()
    {
        return 'app_login';
    }
}
