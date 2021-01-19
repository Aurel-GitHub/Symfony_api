<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        //Fixtures pour categories
        for($i = 1; $i <= 3; $i++){
            $category = new Category();
            $category->setTitle($faker->sentence())
                     ->setDescription($faker->paragraph());
            $manager->persist($category);

            //Fixtures pour articles
            for ($j = 1; $j <= mt_rand(4,6); $j ++)
            {
                $article = new Article();

                $content ='<p>' . join($faker->paragraphs(5), '</p><p>') .'</p>';

                $article->setTitle($faker->sentence())
                        ->setContent($content)
                        ->setImage('https://via.placeholder.com/350x150')
                        ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                        ->setCategory($category);
                $manager->persist($article);

                //Fixtures pour commentaire
                for($k = 1; $k <= mt_rand(4,10); $k++)
                {
                    $comment = new Comment();

                    $contentComment = '<p>' . join($faker->paragraphs(2), '</p><p>') . '</p>';

                    $days = (new \DateTime())->diff($article->getCreatedAt())->days;  //diff différence entre deux objets de type dateTime

                    $comment->setAuthor($faker->name)
                            ->setContent($contentComment)
                            ->setCreatedAt($faker->dateTimeBetween('-' . $days . 'days'))
                            ->setArticle($article);
                    $manager->persist($comment);
                }
            }
        }
        $manager->flush();
    }
}
