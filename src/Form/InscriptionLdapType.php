<?php


namespace App\Form;


use App\Entity\InscriptionLdap;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InscriptionLdapType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('hostname')
            ->add('port')
            ->add('basedn')
            ->add('binddn')
            ->add('password', PasswordType::class)
            ->add('cheminRoom');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => InscriptionLdap::class,
            ]
        );
    }

    public function getBlockPrefix()
    {
        return null;
    }
}