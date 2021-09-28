<?php

namespace App\Service;

use App\Entity\Article;

class ArticleService {
    
    public function upsertArticle($data, $em, $article = null) {
        if (!$article) {
            $article = new Article();
        }
        
        $article->setTitle($data['title']);
        $article->setLeadingBody($data['leading_body']);
        $article->setBody($data['body']);
        $article->setSlug($data['slug']);
        $article->setCreatedBy($data['created_by']);
        
        $em->persist($data);
        $em->flush();
        
        return $article;
    }
}
