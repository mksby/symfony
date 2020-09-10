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
     * @Route("/catalog")
    */
    public function index(Request $request): Response
    {
        $brands = $this->getDoctrine()->getRepository(Brand::class)->findAll();
        $models = $this->getDoctrine()->getRepository(Model::class)->findAll();
        $engines = $this->getDoctrine()->getRepository(Engine::class)->findAll();

        $search = new Search();

        $form = $this->createForm(SearchType::class, $search, [
            'brands' => $brands,
            'models' => $models,
            'engines' => $engines
        ]);

        // dump($form->createView());

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->getData();
        }

        return $this->render('catalog/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}