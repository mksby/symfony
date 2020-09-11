<?php

namespace App\Form\Type;

use App\Entity\Brand;
use App\Entity\Engine;
use App\Entity\Model;
use App\Entity\Search;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
    private EntityManagerInterface $em;
    private $options;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->options = $options;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'onPreSetData'));
        $builder->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmit'));
    }

    protected function addElements(FormInterface $form, Brand $brand = null, Model $model = null, Engine $engine = null)
    {
        $form
            ->add('brand', EntityType::class, [
                'label' => 'Марки',
                'required' => true,
                'placeholder' => 'Выберите марку',
                'choice_label' => fn($model) => $model->getName(),
                'data' => $brand,
                'class' => Brand::class,
                'attr' => [
                    'data-url-models' => '/api/catalog/models'
                ]
            ]);

        $models = [];

        if ($brand) {
            $models = $this->em->getRepository(Model::class)
                ->createQueryBuilder('q')
                ->where("q.brand_id = :brand_id")
                ->setParameter("brand_id", $brand->getId())
                ->getQuery()
                ->getResult();
        }

        $form->add('model', EntityType::class, [
                'label' => 'Модели',
                'required' => false,
                'placeholder' => 'Выберите модель' . (empty($models) ? '' : ' ' . $brand->getName() . ' ...'),
                'class' => Model::class,
                'choices' => $models,
                'choice_label' => fn($model) => $model->getName(),
                'data' => $model,
                'disabled' => empty($models)
        ]);

        $form->add('engine', EntityType::class, [
                'label' => 'Двигатели',
                'required' => false,
                'placeholder' => 'Выберите двигатель',
                'choice_label' => fn($model) => $model->getName(),
                'class' => Engine::class,
                'data' => $engine
            ])
            ->add('Find', SubmitType::class);
    }

    function onPreSubmit(FormEvent $event) {
        $form = $event->getForm();
        $model = $event->getData();

        $brand = $this->em->getRepository(Brand::class)->findOneBy(['id' => $model['brand']]);
        $model = $this->em->getRepository(Model::class)->findOneBy(['id' => $model['model']]);
        $engine = $this->em->getRepository(Engine::class)->findOneBy(['id' => $this->options['engine']]);

        $this->addElements($form, $brand, $model, $engine);
    }

    function onPreSetData(FormEvent $event) {
         $form = $event->getForm();

         $brand = $this->em->getRepository(Brand::class)->findOneBy(['name' => $this->options['brand']]);
         $model = $this->em->getRepository(Model::class)->findOneBy(['name' => $this->options['model']]);
         $engine = $this->em->getRepository(Engine::class)->findOneBy(['name' => $this->options['engine']]);

         $this->addElements($form, $brand, $model, $engine);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Search::class,
            'brand' => null,
            'model' => null,
            'engine' => null
        ]);
    }
}