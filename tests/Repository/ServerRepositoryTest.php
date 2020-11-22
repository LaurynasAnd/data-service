<?php
namespace App\Tests\Repository;

use App\Entity\Server;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ServerRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testGetStatistics()
    {
        $tests = [
            [
                'date' => '2010-01-01',
                'client' => 'A',
                'sign_smartid' => 7609,
                'authorize_smartid' => 2226
            ],
            [
                'date' => '2010-01-04',
                'client' => 'I',
                'sign_smartid' => 8006,
                'authorize_smartid' => 8878
            ],
            [
                'date' => '2010-01-10',
                'client' => 'H',
                'sign_smartid' => 7885,
                'authorize_smartid' => 6774
            ],
            [
                'date' => '2010-01-14',
                'client' => 'U',
                'sign_smartid' => 5389,
                'authorize_smartid' => 6146
            ],
            [
                'date' => '2010-01-18',
                'client' => 'M',
                'sign_smartid' => 2134,
                'authorize_smartid' => 9792
            ],
        ];

        //here database connection is tested
        foreach ($tests as $test){
            $server = $this->entityManager
                ->getRepository(Server::class)
                ->findOneBy([
                    'date' => new \DateTime($test['date']),
                    'client' => $test['client']
                ])
            ;
            $this->assertSame($test['sign_smartid'], $server->getSignSmartid());
            $this->assertSame($test['authorize_smartid'], $server->getAuthorizeSmartid());
        }
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // this is done to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
