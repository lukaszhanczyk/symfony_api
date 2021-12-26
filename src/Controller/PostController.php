<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractApiController
{
    /**
     * Lists all Movies.
     * @Rest\Get("/api/posts")
     * @return Response
     */
    public function readPosts(PostRepository $postRepository): Response
    {
        $posts = $postRepository->findAll();
        return $this->handleView($this->view([
            'posts' => $posts
        ], Response::HTTP_OK));
    }

    /**
     * Lists all Movies.
     * @Rest\Post("/api/posts")
     * @return Response
     */
    public function createPosts(Request $request):Response
    {
        $form = $this->buildForm(PostType::class);
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
     * @Rest\Patch("/api/posts/{id}")
     * @return Response
     */
    public function updatePosts(Post $post, Request $request):Response
    {
        $form = $this->buildForm(PostType::class, $post, [
            'method'=>'PATCH'
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $post = $form->getData();
            $em->persist($post);
            $em->flush();
            return $this->handleView($this->view([$post], Response::HTTP_OK));
        }
        return $this->handleView($this->view($form->getErrors()));
    }

    /**
     * Create Movie.
     * @Rest\Delete("/api/posts/{id}")
     *
     * @return Response
     */
    public function deletePosts(Post $post)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();
        return $this->handleView($this->view([$post], Response::HTTP_OK));
    }
}
