<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends AbstractApiController
{
    /**
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
     * @Rest\Patch("/api/categories/{id}")
     * @return Response
     */
    public function updateCategories(Category $category, Request $request):Response
    {
        $form = $this->buildForm(CategoryType::class, $category, [
            'method'=>'PATCH'
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

    /**
     * @Rest\Delete("/api/categories/{id}")
     *
     * @return Response
     */
    public function deleteCategories(Category $category, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        $em->flush();
        return $this->handleView($this->view([$category], Response::HTTP_OK));
    }
}
