<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArticleApiController extends AbstractController
{
    /**
     * @Route("/article/api", name="article_api")
     */
    public function index()
    {
        return $this->render('article_api/index.html.twig', [
            'controller_name' => 'ArticleApiController',
        ]);
    }
}
