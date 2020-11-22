<?php

namespace App\Controller;

use App\Entity\Server;
use App\Repository\ServerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use League\Csv\Reader;
use Symfony\Component\Serializer\SerializerInterface;

use function PHPSTORM_META\type;

/**
 * @Route("/api")
 */
class ServerController extends AbstractController
{
    
    
    /**
     * @Route("/data")
     */
    public function getData(ServerRepository $serverRepository, SerializerInterface $serializer) : Response
    {
        $data = $serverRepository->getStatistics('A');
        $json = $serializer->serialize($data, 'json');
        _prd($json);
        return new Response($json);
    }
}
