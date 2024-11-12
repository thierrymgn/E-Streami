<?php

namespace App\Repository;

use App\Entity\Media;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Media>
 */
class MediaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Media::class);
    }

       /**
        * @return Media[] Returns an array of Media objects
        */
       public function findTrendingMedia(int $maximumEl = 9): array
       {
           return $this->createQueryBuilder('m')
                ->orderBy('m.releaseDate', 'DESC')
                ->setMaxResults($maximumEl)
                ->getQuery()
                ->getResult()
           ;
       }

    //    public function findOneBySomeField($value): ?Media
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
