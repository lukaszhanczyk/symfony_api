<?php

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractApiController
{
    /**
     * Lists all Movies.
     * @Rest\Get("/api/posts")
     * @return Response
     */
    public function index(): Response
    {
        return $this->handleView($this->view([
            'posts' => ''
        ], Response::HTTP_OK));
    }
}
