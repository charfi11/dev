<?php

namespace App\Repository;

use App\Data\Search;
use App\Entity\Astuce;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Astuce|null find($id, $lockMode = null, $lockVersion = null)
 * @method Astuce|null findOneBy(array $criteria, array $orderBy = null)
 * @method Astuce[]    findAll()
 * @method Astuce[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AstuceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Astuce::class);
    }

     /**
      * @return Astuce[] Returns an array of Astuce objects
      */
    
    public function findSearch(Search $search, $value ,Request $r)
    {

        $query = $this->createQueryBuilder('a')
            ->join('a.categoris', 'c')
            ->andWhere('c.id = :val')
            ->setParameter('val', $value);

        $filter = $r->query->get('search')["filtrer"];

        if($filter === 'Récent'){

        $query = $query
        ->orderBy('a.date', 'DESC')
        ->setMaxResults(10);

        }

        if($filter === 'Ancien'){

        $query = $query
        ->orderBy('a.date', 'ASC')
        ->setMaxResults(10);

        }

        return $query->getQuery()->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?Astuce
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
