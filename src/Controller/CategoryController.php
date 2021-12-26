<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends AbstractFOSRestController
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
}
