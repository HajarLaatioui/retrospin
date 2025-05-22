<?php

namespace App\Form;

use App\Entity\Artist;
use App\Entity\Genre;
use App\Entity\Vinyl;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VinylTypeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('releaseYear')
            ->add('description')
            ->add('isAvailable')
            ->add('artist', EntityType::class, [
                'class' => Artist::class,
                'choice_label' => 'name',
            ])
            ->add('genre', EntityType::class, [
                'class' => Genre::class,
                'choice_label' => 'name',
            ])
            ->add('stock', IntegerType::class, [
                'label' => 'Stock disponible',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vinyl::class,
        ]);
    }
}
