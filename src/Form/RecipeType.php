<?php

namespace App\Form;

use App\Entity\Recipe;
use App\Entity\Step;
use App\Form\IngredientQuantityType;
use App\Form\StepType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('preparationTime', IntegerType::class)
            ->add('cookingTime', IntegerType::class)
            // ->add('users', CollectionType::class, ['entry_type' => User::class])
            ->add('steps', CollectionType::class, [
                'entry_type' => StepType::class,
                'entry_options' => [
                    'label' => false
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false
                ])
            ->add('ingredientQuantities', CollectionType::class, [
                'entry_type' => IngredientQuantityType::class,
                'entry_options' => [
                    'label' => false
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false
                ])
            // ->add('comments', CollectionType::class, ['entry_type' => Comment::class])
            -> add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}
