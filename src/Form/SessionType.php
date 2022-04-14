<?php

namespace App\Form;

use App\Entity\Formateur;
use App\Entity\Formation;
use App\Entity\Session;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('intitule', TextType::class)
            ->add('dateDebut', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('dateFin', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('places_theoriques', NumberType::class, [
                'attr' => [
                    'min' => '1',
                    'max' => '25',
                ],
            ])
            ->add('placesReserves', NumberType::class)
            ->add('formateurs', EntityType::class, [
                'class' => Formateur::class,
            ])
            ->add('formations', EntityType::class, [
                'class' => Formation::class,
            ])

            ->add('planifiers', CollectionType::class, [ // Collection va attendre un element qu'elle entrera dans le form
                'entry_type' => PlanifierType::class,
                'prototype' => true, // Attend un objet planifier
                'allow_add' => true, // Autorise l'ajout
                'allow_delete' => true, // Autorise la supression
                'by_reference' => false,
            ])
            ->add('Ajouter', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Session::class,
        ]);
    }
}
