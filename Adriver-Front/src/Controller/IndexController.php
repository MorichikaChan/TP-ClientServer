<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Form\ArticleType;


/**
 * @Route("/")
 */
class IndexController extends AbstractController
{
    private $client;
    private $api;
    
    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
        $this->api = "http://localhost:8000/";
    }
    
    /**
     * @Route("", name="article_index")
     */
    public function index(): Response
    {
        $response = $this->client->request(
            'GET',
            $this->api.'article/'
        );
        $content = $response->getContent();
        
        $array_data = \get_object_vars(\json_decode($content));
        $articles = \json_decode($array_data['articles'], true);
        foreach ($articles as $key => $article) {
            $articles[$key]['createdAt'] = date('Y-m-d H:i:s', $article['createdAt']['timestamp']);
        }
        
        return $this->render('index.html.twig', [
            'articles' => $articles,
        ]);
    }
    
    /**
     * @Route("article/{slug}", name="article_read")
     */
    public function read(string $slug): Response
    {
        $response = $this->client->request(
            'GET',
            $this->api.'article/'.$slug
        );
        $content = $response->getContent();
        $article = \json_decode($content, true)['article'];
        $article['createdAt'] = \DateTime::createFromFormat('Y-m-d H:i:s', $article['createdAt']);
        
        return $this->render('article.html.twig', [
            'article' => $article,
        ]);
    }
    
    /**
     * @Route("creer", name="article_create")
     */
    public function create(Request $request): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $this->client->request(
                'POST',
                $this->api.'article/', 
                [
                    'body' => \json_encode($article), 
                ]
            );
            return $this->redirectToRoute('article_read', ['slug' => $article->getSlug()], Response::HTTP_SEE_OTHER);
        } else {
            return $this->renderForm('form.html.twig', [
                'article' => 'Créer un article',
                'form' => $form,
            ]);
        }
    }
    
    /**
     * @Route("article/delete/{slug}", name="article_delete")
     */
    public function delete(string $slug): Response
    {
        $this->client->request(
            'DELETE',
            $this->api.'article/'.$slug
        );
        return $this->redirectToRoute('article_index', [], Response::HTTP_SEE_OTHER);
    }
}