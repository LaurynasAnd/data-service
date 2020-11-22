<?php

namespace App\Repository;

use App\Entity\Server;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Server|null find($id, $lockMode = null, $lockVersion = null)
 * @method Server|null findOneBy(array $criteria, array $orderBy = null)
 * @method Server[]    findAll()
 * @method Server[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Server::class);
    }

    // /**
    //  * @return Server[] Returns an array of Server objects
    //  */
    
    public function getStatistics($client)
    {
        // $qb = $this->createQueryBuilder('s');
        // return $qb
        //     ->select('FORMAT(s.date, \'yyyy-MM\') as month, s.client,  count(s.sign_smartid) as count')
        //     // ->from('\Server', 's')
        //     ->groupBy('month, s.client')
        //     ->orderBy('s.client', 'ASC')
        //     ->getQuery()
        //     ->getResult()
        // ;
        // return $qb
        //     ->select('DATE_FORMAT(s.date, \'%Y-%m\') as month, s.client, count(s.sign_smartid)')
        //     ->groupBy('month')
        //     ->orderBy('s.client', 'ASC')
        //     ->getQuery()
        //     ->getResult()
        // ;
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT DATE_FORMAT(s.date, \'%Y-%m\') as month, s.client,  count(s.sign_smartid) as count 
            FROM server s
            GROUP BY month, s.client
            ORDER BY s.client ASC, month
            ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAllAssociative();
    }
    

    /*
    public function findOneBySomeField($value): ?Server
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
