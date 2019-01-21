<?php

namespace App\Entity\Sonata_Professionnal;

use App\Entity\Room;
use App\Entity\TypeOfRoom;
use App\Form\ImageRoomType;
use App\Traits\TransliteratorSlugTrait;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\Form\Type\BooleanType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class RoomAdministration extends AbstractAdmin
{
    use TransliteratorSlugTrait;

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
                    ->add('images', CollectionType::class, [
                        'by_reference' => false,
                        'entry_type' => ImageRoomType::class,
                        'entry_options' => ['label' => 'Images'],
                        'allow_add' => true,
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
            ->addIdentifier('name', TextType::class)
            ->add('priceLocation', MoneyType::class)
            ->add('placeCapacity', IntegerType::class)
            ->add('disponible', BooleanType::class)
            ->add('ville', TextType::class)
            ->add('address', TextType::class)
            ->add('postalCode', TextType::class)
            ;
    }

    public function toString($object)
    {
        return $object instanceof Room ? $object->getName() : 'Salle crée';
    }

    public function prePersist($object)
    {
        if ($object instanceof Room) {
            $object->setSlug($this->slugify(strtolower($object->getName().'-'.$object->getVille())));
            $images = $object->getImages();
            foreach ($images as $image) {
                $image->setName('Booking'.uniqid('', true));
            }
        }
    }
}
