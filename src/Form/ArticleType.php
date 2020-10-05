<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                    ->add('title', TextType::class,['attr' => ['placeholder' => 'Titre de l\'artice', 'class' => 'form-control']])
                    ->add('content', TextareaType::class, ['attr'=>['placeholder'=> 'Contenu', 'class' => 'form-control']])
                    ->add('image',TextType::class, ['attr'=>['placeholder'=> 'en attente du bundle VichUploadFile pour les images !!!' , 'class' => 'form-control']])
                    ->add('category', EntityType::class, ['class'=> Category::class, 'choice_label'=> 'title'])
                    ->getForm();
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
