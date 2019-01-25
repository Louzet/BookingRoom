<?php
/**
 * Created by PhpStorm.
 * User: mickael
 * Date: 24/01/19
 * Time: 11:19.
 */

namespace App\Form;

use App\DataTransformer\villeToEntityTransformer;
use App\Entity\Search;
use App\Entity\TypeOfRoom;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MiniSearchBarType extends AbstractType
{
    /**
     * @var villeToEntityTransformer
     */
    private $villeTransformer;

    public function __construct(villeToEntityTransformer $villeTransformer)
    {
        $this->villeTransformer = $villeTransformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('evenement', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => TypeOfRoom::class,
                'choice_label' => 'title',
                'placeholder' => ' ',
                'attr' => [
                ],
            ])
            ->add('place', TextType::class, [
                'label' => false,
                'required' => false,
                'label_attr' => [
                    'class' => 'label-loader',
                ],
                'attr' => [
                    'class' => 'typeahead',
                    'id' => 'villes',
                    'autocomplete' => 'off',
                    'placeholder' => 'Entrez une ville',
                ],
            ])
            ;
        $builder->get('place')->addModelTransformer($this->villeTransformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Search::class,
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
