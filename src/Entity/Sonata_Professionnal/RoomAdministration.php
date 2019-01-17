<?php

namespace App\Entity\Sonata_Professionnal;

use App\Entity\Room;
use App\Entity\TypeOfRoom;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class RoomAdministration extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->tab('Informations', ['class' => 'col-md-9'])
                ->with('Salles')
                    ->add('name', TextType::class)
                    ->add('priceLocation', MoneyType::class)
                    ->add('placeCapacity', IntegerType::class)
                    ->add('disponible', CheckboxType::class, [
                        'required' => false,
                    ])
                ->end()
            ->end()
            ->tab('Adresse')
                ->with('')
                    ->add('ville', TextType::class, [
                        'attr' => [
                            'class' => 'col-md-3',
                        ],
                    ])
                    ->add('address', TextareaType::class, [
                        'attr' => [
                            'class' => 'col-md-6',
                        ],
                    ])
                    ->add('postalCode', TextType::class, [
                        'attr' => [
                            'class' => 'col-md-3',
                        ],
                    ])
                ->end()
            ->end()
            ->tab('Type de salle', ['class' => 'col-md-3'])
                ->with('Type de salle')
                    ->add('type', EntityType::class, [
                        'class' => TypeOfRoom::class,
                        'choice_label' => 'title',
                        'expanded' => false,
                        'multiple' => false,
                    ])
                ->end()
            ->end()
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')

            ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('priceLocation', MoneyType::class)
            ->add('placeCapacity', IntegerType::class)
            ;
    }

    public function prePersist($object)
    {
        dump($object);
    }

    public function toString($object)
    {
        return $object instanceof Room ? $object->getName() : 'Salle crée';
    }
}
