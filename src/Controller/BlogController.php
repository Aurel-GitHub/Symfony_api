<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
     private $em;

    public function __construct(EntityManagerInterface $em)
    {
                $this->em= $em;
    }

    /**
     * @Route("/blog", name="blog")
     */
    public function index(ArticleRepository $repository)
    {
        $articles = $repository->findAll();
        return $this->render('blog/index.html.twig', ['articles' => $articles]);
    }


    /**
     * @Route("/blog/new", name="blog_create")
     * @Route("/blog/{id}/edit", name="blog_edit")
     */
    public function form(Article $article = null, Request $request, EntityManagerInterface $em)
    {
        if(!$article){
            $article = new Article();
        }

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            if(!$article->getId()){
                $article->setCreatedAt(new \DateTime());
            }

            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('show', ['id' => $article->getId()]);
        }

        return $this->render('blog/create.html.twig', ['article' => $form->createView(), 'editMode'=> $article->getId() !== null]);
    }

    /**
     * @Route("/blog/{id}", name="blog_delete", methods="DELETE")
     */
    public function delete(Article $article, Request $request, EntityManagerInterface $em) {
        if ($this->isCsrfTokenValid('delete' . $article->getId(), $request->get('_token'))) {
            $this->em->remove($article);
            $this->em->flush();
            $this->addFlash('success', 'Bien supprimé avec succès');
        }
        return $this->redirectToRoute('blog');
    }


    /**
     * @Route("/blog/{id}", name="show")
     */
    public function show(ArticleRepository $repository, $id)
    {
        $article = $repository->find($id);
        return $this->render('blog/show.html.twig',['article'=>$article]);
    }

    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('blog/home.html.twig', [
            'titre'=> 'test'
        ]);
    }


}
