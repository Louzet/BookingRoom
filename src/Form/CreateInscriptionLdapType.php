<?php

namespace App\Form;


use App\Entity\InscriptionLdap;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateInscriptionLdapType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            # Champ Nom
            ->add('name', TextType::class, [
                'required' => true,
                'label' => 'Nom ',
                'attr' => ['placeholder' => 'Un nom pour votre LDAP'
                ]
            ])
            # Champ Hostname
            ->add('hostname', TextType::class, [
                'required' => true,
                'label' => 'Hostname ',
                'attr' => ['placeholder' => 'exemple.com'
                ]
            ])
            # Champ Port
            ->add('port', TextType::class, [
                'required' => true,
                'label' => 'Port ',
                'attr' => ['placeholder' => '389'
                ]
            ])
            # Champ BaseDN
            ->add('basedn', TextType::class, [
                'required' => true,
                'label' => 'BaseDN ',
                'attr' => ['placeholder' => 'dc=exemple,dc=com'
                ]
            ])
            # Champ BindDN
            ->add('binddn', TextType::class, [
                'required' => true,
                'label' => 'BindDN ',
                'attr' => ['placeholder' => 'cn=admin,dc=exemple,dc=com'
                ]
            ])

            # Champ password
            ->add('password', PasswordType::class, [
                'required' => true,
                'label' => 'Password ',
                'attr' => ['placeholder' => '************'
                ]
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => InscriptionLdap::class,
            ]
        );
    }

}