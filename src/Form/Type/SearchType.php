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
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('brand', ChoiceType::class, [
                'label' => 'Марки',
                'required' => false,
                'placeholder' => 'Выберите марку',
                'choices' => $options['brand'],
                'choice_label' => fn($model) => $model->getName(),
                'data' => $options['selected_brand']
            ])
            ->add('model', ChoiceType::class, [
                'label' => 'Модели',
                'required' => false,
                'placeholder' => 'Выберите модель',
                'choices' => $options['model'],
                'choice_label' => fn($model) => $model->getName(),
                'data' => $options['selected_model']
            ])
            ->add('engine', ChoiceType::class, [
                'label' => 'Двигатели',
                'required' => false,
                'placeholder' => 'Выберите двигатель',
                'choices' => $options['engine'],
                'choice_label' => fn($model) => $model->getName(),
                'data' => $options['selected_engine']
            ])
            ->add('Find', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Search::class,
            'brand' => null,
            'model' => null,
            'engine' => null,
            'selected_brand' => null,
            'selected_model' => null,
            'selected_engine' => null
        ]);
    }
}