<?php
// src/Controller/CatalogController.php
namespace App\Controller;

use App\Entity\Search;
use App\Entity\Brand;
use App\Entity\Model;
use App\Entity\Engine;
use App\Form\Type\SearchType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CatalogController extends AbstractController
{
    /**
     * @Route("/catalog", methods={"GET", "POST"})
     * @return Response
    */
    public function index(Request $request): Response
    {
        $search = new Search();

        $form = $this->createForm(SearchType::class, $search);

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
     * @return Response
    */
    public function findModelsOfBrands(Request $request, $brand, $model): Response
    {
        $brandReposity = $this->getDoctrine()->getRepository(Brand::class);
        $modelReposity = $this->getDoctrine()->getRepository(Model::class);

        $selectedBrand = $brandReposity->findOneBy(['name' => $brand]);
        $selectedModel = $modelReposity->findOneBy(['name' => $model]);

        $search = new Search();

        $form = $this->createForm(SearchType::class, $search);

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

    /**
     * @Route("/catalog/models", name="catalog_models", methods={"GET"})
     * @param Request $request
     * @return JsonResponse
     */
    public function findModelsOfBrand(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $modelRepository = $em->getRepository(Model::class);

        $models = $modelRepository->createQueryBuilder("q")
            ->where("q.brand_id = :brand_id")
            ->setParameter("brand_id", $request->query->get("brand_id"))
            ->getQuery()
            ->getResult();

        $responseArray = [];
        foreach($models as $model) {
            $responseArray[] = [
                "id" => $model->getId(),
                "name" => $model->getName()
            ];
        }

        return new JsonResponse($responseArray);
    }
}