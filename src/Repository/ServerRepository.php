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
    //  * @return array Return raw data
    //  */
    
    public function getStatistics()
    {
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
}
