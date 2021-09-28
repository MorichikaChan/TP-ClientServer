<?php

// tests/Service/NewsletterGeneratorTest.php
namespace App\Tests\Service;

use App\Service\ArticleService;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ArticleTest extends KernelTestCase {
    
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }
    
    public function testSearchByName()
    {
        $article = $this->entityManager
            ->getRepository(Article::class)
            ->findOneBy(['title' => 'Lorem ipsum dolor sit amet']);

        $this->assertSame('brouillon', $article->getStatus());
    }
    
    public function createArticleTest(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $articleService = $container->get(ArticleService::class);
        $data = [
            "title" => "Lorem",
            "leading_body" => "Ispum",
            "body" => "Lorem Ispum",
            "slug" => "LoremIspum",
            "created_by" => "Max",
        ];
        $status = $articleService->upsertArticle($data, $this->entityManager);
        
        $this->assertEquals(200, http_response_code($status));
    }
    
    public function editArticleTest(ArticleRepository $articleRepo): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $articleService = $container->get(ArticleService::class);
        $article = $articleRepo->find(999);
        $data = [
            "title" => "Lorem",
            "leading_body" => "Ispum",
            "body" => "Lorem Ispum",
            "slug" => "LoremIspum",
            "created_by" => "Max",
        ];
        $status = $articleService->upsertArticle($data, $this->entityManager, $article);
        
        $this->assertEquals(200, http_response_code($status));
    }
    
    public function deleteArticleTest(ArticleRepository $articleRepo): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $article = $articleRepo->find(999);
        $articleService = $container->get(ArticleService::class);
        
        $status = $articleService->deleteArticle($article, $this->entityManager);
        
        $this->assertEquals(200, http_response_code($status));
    }
    
    
}
