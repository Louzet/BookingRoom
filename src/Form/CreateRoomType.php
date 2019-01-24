<?php

namespace App\Form;



use App\Entity\Room;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateRoomType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            # Champ Nom
            ->add('name', TextType::class, [
                'required' => true,
                'label' => 'Nom ',
                'attr' => ['placeholder' => 'Le nom de la salle '
                ]
            ])
            # Champ PriceLocation
            ->add('priceLocation', TextType::class, [
                'required' => true,
                'label' => 'Price Location ',
                'attr' => ['placeholder' => 'xx euros'
                ]
            ])
            # Champ PlaceCapacity
            ->add('placeCapacity', TextType::class, [
                'required' => true,
                'label' => 'Place capacity ',
                'attr' => ['placeholder' => 'xxx personnes'
                ]
            ])
            # Champ ville
            ->add('ville', TextType::class, [
                'required' => true,
                'label' => 'Ville ',
                'attr' => ['placeholder' => 'Ville de la salle'
                ]
            ])
            # Champ Address
            ->add('address', TextType::class, [
                'required' => true,
                'label' => 'Address ',
                'attr' => ['placeholder' => 'Adresse de la salle'
                ]
            ])
            # Champ PostalCode
            ->add('postalCode', TextType::class, [
                'required' => true,
                'label' => 'Postal Code ',
                'attr' => ['placeholder' => 'XXXXX'
                ]
            ])
            # Champ Disponible
            ->add('disponible', TextType::class, [
                'required' => true,
                'label' => 'Disponible ',
                'attr' => ['placeholder' => 'Vrai/Faux'
                ]
            ])
            # Champ Type
            ->add('type', TextType::class, [
                'required' => true,
                'label' => 'Postal Code ',
                'attr' => ['placeholder' => 'XXXXX'
                ]
            ])
            # Champ DateCreation
            ->add('dateCreation', TextType::class, [
                'required' => true,
                'label' => 'Date Création ',
                'attr' => ['placeholder' => 'XX/XX/XXXX'
                ]
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Room::class,
            ]
        );
    }

}