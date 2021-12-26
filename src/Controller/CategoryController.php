<?php

namespace App\Controller;

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
    public function readPosts(CategoryRepository $categoryRepository): Response
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
    public function createPosts(Request $request):Response
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
}
