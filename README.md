#symfony_api

1. Routing
    - App\Controller\PostController
        - @Rest\Get("/api/posts") - additional filtering params (example: /api/posts?category=1&offset=0&limit=200):
           - category (category id)
           - limit
           - offset
        - @Rest\Post("/api/posts")
        - @Rest\Patch("/api/posts/{id}")
        - @Rest\Delete("/api/posts/{id}")
    - App\Controller\CategoryController
      - @Rest\Get("/api/categories")
      - @Rest\Post("/api/categories")
      - @Rest\Patch("/api/categories/{id}")
      - @Rest\Delete("/api/categories/{id}")
2. Entities
   - App\Entity\Post 
     - id #[ORM\Column(type: 'integer')]
     - title #[ORM\Column(type: 'string', length: 200)]
     - text #[ORM\Column(type: 'text')]
     - category #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'posts')]
   - App\Entity\Category
       - id #[ORM\Column(type: 'integer')]
       - name #[ORM\Column(type: 'string', length: 200)]
       - posts #[ORM\OneToMany(mappedBy: 'category', targetEntity: Post::class)]
3. Repositories
   - App\Repository\PostRepository
     - ::findByCategory($id, $offset = 0, $limit = 200) - filter by category
     - ::findAll($offset = 0, $limit = 200)
   - App\Repository\CategoryRepository