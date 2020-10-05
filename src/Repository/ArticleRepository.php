<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function updateQuery($id, $data)
    {
        $queryBuilder = $this->createQueryBuilder('a')
            ->update('App:Article', 'a')
            ->set('a.title', '?1')
            ->set('a.content', '?2')
            ->set('a.image', '?3')
            ->where('a.id = :id')
            ->setParameter(1, $data->getTitle())
            ->setParameter(2, $data->getContent())
            ->setParameter(3, $data->getImage())
            ->setParameter('id', $id);
        $queryBuilder->getQuery()->execute();

        /**
         * Affichage des changments
         */
        $queryBuilder = $this->createQueryBuilder('a')
            ->select('a.title', 'a.content')
            ->where('a.id = :id')
            ->setParameter('id', $id);
        return $queryBuilder->getQuery()->getResult();

    }

    public function deleteQuery($id)
    {
        $qb = $this->createQueryBuilder('a')
                    ->delete('App:Article', 'a')
                    ->where('a.id = :id')
                    ->setParameter('id', $id)
        ;
        return $qb->getQuery()->execute();
    }

    public function deleteQueryTest($idArticle, $id)
    {
//    ('u.Phonenumbers', 'p', Expr\Join::WITH, 'p.is_primary = 1');
//        *         ->from('User', 'u');


        $queryBuilder = $this->createQueryBuilder('a')
            ->delete('App:Article', 'a')
            ->from('Article', 'a')
            ->andWhere('a.id = :id')
            ->setParameter('id', $idArticle)
            ->leftJoin('a.comments', 'c', 'WITH', 'c.id');
//            ->delete('App:Comment', 'c')
//            ->andWhere('c.id = :id')
//            ->setParameter('id', $idComment);
         $queryBuilder->getQuery()->execute();
    }



}
