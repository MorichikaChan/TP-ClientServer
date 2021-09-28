<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ArticleRepository;
use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/article")
 */
class ArticleController extends AbstractController
{
    private $serializer;

    public function __construct()
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $this->serializer = new Serializer($normalizers, $encoders);
    }
    
    /**
     * @Route("/", name="article_index", methods={"GET"})
     */
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->json([
            'articles' => $this->serializer->serialize($articleRepository->findAll(), 'json'), 
        ]);
    }

    /**
     * @Route("/", name="article_new", methods={"POST"})
     */
    public function create(Request $request, EntityManagerInterface $em)
    {
        $article = $this->serializer->deserialize($request->getContent(), Article::class, 'json');
        $em->persist($article);
        $em->flush();
        return $this->json([
            'article' => $article,
            'code' => 200
        ]);
    }

    /**
     * @Route("/{slug}", name="article_show", methods={"GET"})
     */
    public function show(Article $article): Response
    {
        return $this->json([
            'article' => $article,
        ]);
    }
    
    /**
     * @Route("/{slug}", name="article_delete", methods={"DELETE"})
     */
    public function delete(Article $article, EntityManagerInterface $em): Response
    {   
        $em->remove($article);
        $em->flush();
        return $this->json([
            'code' => 200,
        ]);
    }
    
}
