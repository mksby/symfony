<?php

namespace App\Form\Type;

use App\Entity\Search;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('brands', ChoiceType::class, [
                'label' => 'Марки',
                'required' => false,
                'placeholder' => 'Выберите марку',
                'choices' => $options['brands'],
                'choice_label' => fn($model) => $model->getName()
            ])
            ->add('models', ChoiceType::class, [
                'label' => 'Модели',
                'placeholder' => 'Выберите модель',
                'choices' => $options['models'],
                'choice_label' => fn($model) => $model->getName()
            ])
            ->add('engines', ChoiceType::class, [
                'label' => 'Двигатели',
                'placeholder' => 'Выберите двигатель',
                'choices' => $options['engines'],
                'choice_label' => fn($model) => $model->getName()
            ])
            ->add('Find', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Search::class,
            'brands' => null,
            'models' => null,
            'engines' => null
        ]);
    }
}