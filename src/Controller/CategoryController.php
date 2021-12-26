<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends AbstractApiController
{
    /**
     * Lists all Movies.
     * @Rest\Get("/api/categories")
     * @return Response
     */
    public function readCategories(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        return $this->handleView($this->view([
            'categories' => $categories
        ], Response::HTTP_OK));
    }

    /**
     * Lists all Movies.
     * @Rest\Post("/api/categories")
     * @return Response
     */
    public function createCategories(Request $request):Response
    {
        $form = $this->buildForm(CategoryType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $category = $form->getData();
            $em->persist($category);
            $em->flush();
            return $this->handleView($this->view([$category], Response::HTTP_CREATED));
        }
        return $this->handleView($this->view($form->getErrors()));
    }

    /**
     * Lists all Movies.
     * @Rest\Put("/api/categories/{id}")
     * @return Response
     */
    public function updateCategories(Category $category, Request $request):Response
    {
        $form = $this->buildForm(CategoryType::class, $category, [
            'method'=>'PUT'
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $category = $form->getData();
            $em->persist($category);
            $em->flush();
            return $this->handleView($this->view([$category], Response::HTTP_OK));
        }
        return $this->handleView($this->view($form->getErrors()));
    }
}
