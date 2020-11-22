<?php

namespace App\Controller;

use App\Repository\ServerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;


/**
 * @Route("/api")
 */
class ServerController extends AbstractController
{
    
    
    /**
     * @Route("/data", methods={"GET"})
     */
    public function getData(ServerRepository $serverRepository, SerializerInterface $serializer) : Response
    {
        $data = $serverRepository->getStatistics();
        // further data will be converted so that Resonse foormat will be:
        // {"client1":{"month1": "count1", "month2": "count2",}, "client2": {...}}, etc
        $convertedData = [];
        foreach($data as $row){
            $convertedData[$row['month']][$row['client']] = $row['count'];
        }
        $json = $serializer->serialize($convertedData, 'json');
        return new Response($json);
    }
}
