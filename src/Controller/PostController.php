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
     * @Rest\Get("/api/posts")
     * @return Response
     */
    public function readPosts(Request $request, PostRepository $postRepository): Response
    {
        $category_id = $request->query->getInt('category') ;
        $limit = $request->query->getInt('limit');
        $offset = $request->query->getInt('offset') ;
        $limit = $limit == 0 ? 200 : $limit;
        if ($category_id == 0)
            $posts = $postRepository->findAll($offset, $limit);
        else
            $posts = $postRepository->findByCategory($category_id, $offset, $limit);
        return $this->handleView($this->view([
            'posts' => $posts,
            'category_id' => $category_id,
            'limit' => $limit,
            'offset' => $offset
        ], Response::HTTP_OK));
    }

    /**
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
