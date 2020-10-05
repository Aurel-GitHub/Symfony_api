<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ArticleApiController extends AbstractController
{
    /**
     * Pour l'api lancer un php -S localhost:3000 -t public
     */


    /**
     * @Route("/api/articles", name="article_api", methods={"GET"})
     */
    public function index(ArticleRepository $repository)
    {
        return $this->json($repository->findAll(), 200, [], ['groups'=> 'article:read']);
    }

    /**
     * @Route("/api/articles", name="articles_post", methods={"POST"})
     */
    public function post(Request $request, SerializerInterface $serializer, EntityManagerInterface $em)
    {
        $json = $request->getContent();

        $article = $serializer->deserialize($json, Article::class, 'json');

        $article->setCreatedAt(new \DateTime());
        $em->persist($article);
        $em->flush();

        return $this->json($article, 201, [], ['groups' => 'article:read']);
    }

    /**
     * @Route("/api/articles/{id}", name="article_update", methods={"PATCH"})
     */
    public function patch(SerializerInterface $serializer,$id, Request $request, ArticleRepository $repository)
    {
        $data = $request->getContent();
        $json = $serializer->deserialize($data, Article::class, 'json');

        $article = $repository->updateQuery($id, $json);

        return $this->json($article, '201', [], ['groups' => 'article:read']);
    }


    /**
     * @todo casscade pour le delete ?
     * @Route("/api/articles/{id}", name="article_delete", methods={"DELETE"})
     */
//    public function delete($id, ArticleRepository $repository, EntityManagerInterface $em, Request $request)
//    {
//        $data = $request->getContent();
//
//        $article = $repository->deleteQueryTest($id, $data);
//
//        return new Response($article, '202');
//    }
    /**
     * @param ArticleRepository $repository
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @Route("/api/articles/{id}", name="article_api_id", methods={"GET"})
     */
    public function byId($id, ArticleRepository $repository)
    {
        return $this->json($repository->find($id), 200, [], ['groups'=> 'article:read']);
    }



    /**
     * @todo à faire pour les filtres
     * @Route("api/articles", name="api_articles_post", methods={"GET"})
     */
    public function byDateDesc()
    {
        //TODO
    }

    /**
     * @todo à faire pour les filtres
     */
    public function byComment()
    {
        //TODO
    }

}
