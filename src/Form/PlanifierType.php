<?php

namespace App\Form;

use App\Entity\ModuleFormation;
use App\Entity\Planifier;
use App\Form\DataTransformer\SessionTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlanifierType extends AbstractType
{
    private $transformer;

    public function __construct(SessionTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('duree', NumberType::class, [
                'label' => 'Durée en jours',
                'attr' => [
                    'min' => '1',
                    'max' => '50',
                ],
            ])
            ->add('sessions', HiddenType::class)
            ->add('modulesFormation', EntityType::class, [
                'label' => 'Module',
                'class' => ModuleFormation::class,
                'choice_label' => 'intitule',
            ])
        ;
        $builder
            ->get('sessions')
            ->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Planifier::class,
        ]);
    }
}
