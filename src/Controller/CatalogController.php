<?php
// src/Controller/CatalogController.php
namespace App\Controller;

use App\Entity\Search;
use App\Entity\Brand;
use App\Entity\Model;
use App\Entity\Engine;
use App\Form\Type\SearchType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CatalogController extends AbstractController
{
    /**
     * @Route("/catalog", methods={"GET", "POST"})
    */
    public function index(Request $request): Response
    {
        $brands = $this->getDoctrine()->getRepository(Brand::class)->findAll();
        $models = $this->getDoctrine()->getRepository(Model::class)->findAll();
        $engines = $this->getDoctrine()->getRepository(Engine::class)->findAll();

        $search = new Search();

        $form = $this->createForm(SearchType::class, $search, [
            'brand' => $brands,
            'model' => $models,
            'engine' => $engines
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->getData();

            return $this->redirectToRoute('catalog_brands_models', [
                'brand' => $search->getBrand()->getName(),
                'model' => $search->getModel()->getName(),
                'engine' => $search->getEngine() ? $search->getEngine()->getName() : null
            ]);
        }

        return $this->render('catalog/index.html.twig', [
            'form' => $form->createView(),
            'brand' => null,
            'model' => null
        ]);
    }

    /**
     * @Route("/catalog/{brand}/{model}", name="catalog_brands_models", methods={"GET", "POST"})
    */
    public function findBrands(Request $request, $brand, $model): Response
    {
        $brandReposity = $this->getDoctrine()->getRepository(Brand::class);
        $modelReposity = $this->getDoctrine()->getRepository(Model::class);
        $engineReposity = $this->getDoctrine()->getRepository(Engine::class);

        $selectedBrand = $brandReposity->findOneBy(['name' => $brand]);
        $selectedModel = $modelReposity->findOneBy(['name' => $model]);
        $selectedEngine = $request->query->all() ? $engineReposity->findOneBy(['name' => $request->query->all()['engine']]) : null;

        $search = new Search();

        $form = $this->createForm(SearchType::class, $search, [
            'brand' => $brandReposity->findAll(),
            'model' => $modelReposity->findAll(),
            'engine' => $engineReposity->findAll(),
            'selected_brand' => $selectedBrand,
            'selected_model' => $selectedModel,
            'selected_engine' => $selectedEngine
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->getData();

            return $this->redirectToRoute('catalog_brands_models', [
                'brand' => $search->getBrand()->getName(),
                'model' => $search->getModel()->getName(),
                'engine' => $search->getEngine() ? $search->getEngine()->getName() : null
            ]);
        }

        return $this->render('catalog/index.html.twig', [
            'form' => $form->createView(),
            'brand' => $selectedBrand,
            'model' => $selectedModel
        ]);
    }
}