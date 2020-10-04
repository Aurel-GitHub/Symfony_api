<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class BlogController extends AbstractController
{
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
     */
    public function create()
    {
        $article = new Article();

        $form = $this->createFormBuilder($article)
                    ->add('title', TextType::class,['attr' => ['placeholder' => 'Titre de l\'artice', 'class' => 'form-control']])
                    ->add('content', TextareaType::class, ['attr'=>['placeholder'=> 'Contenu', 'class' => 'form-control']])
                    ->add('image',TextType::class, ['attr'=>['placeholder'=> 'en attente du bundle VichUploadFile pour les images !!!' , 'class' => 'form-control']])
                    ->add('save', SubmitType::class, ['label'=>'Enrengistrer'])
            ->getForm();



        return $this->render('blog/create.html.twig', ['article' => $form->createView()]);
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
