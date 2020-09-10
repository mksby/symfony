<?php
// src/Controller/CatalogController.php
namespace App\Controller;

use App\Entity\Task;
use App\Entity\Brand;
use App\Form\Type\TaskType;
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
        // $entityManager = $this->getDoctrine()->getManager();
        // $product = new Brand();
        // $product->setName('Test' . rand(0, 1000));
        // $entityManager->persist($product);
        // $entityManager->flush();

        $brands = $this->getDoctrine()->getRepository(Brand::class)->findAll();

        $task = new Task();
        // $task->setTask('Write a blog post');
        // $task->setDueDate(new \DateTime('tomorrow'));
        $task->setBrands($brands);

        $form = $this->createForm(TaskType::class, $task, [
            'brands' => $brands
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();

            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($task);
            // $entityManager->flush();

            // return $this->redirectToRoute('/');
        }

        return $this->render('catalog/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}