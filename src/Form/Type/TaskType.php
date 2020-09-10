<?php

namespace App\Form\Type;

use App\Entity\Task;
use App\Entity\Brand;
use App\Entity\Model;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('task', TextType::class, [
                'label' => 'Марки',
                'required' => false
            ])
            ->add('dueDate', DateType::class)
            ->add('brands', EntityType::class, array(
                'class' => Brand::class,
                'choice_label' => fn($brand, $key, $index) => $brand->getName(),
                'multiple' => true
            ))
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
            'brands' => null
        ]);
    }
}