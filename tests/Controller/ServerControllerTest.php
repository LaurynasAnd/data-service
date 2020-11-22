<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ServerControllerTest extends WebTestCase
{
    public function testGetData()
    {
        $client = static::createClient();

        $client->request('GET', 'api/data');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('string', gettype($client->getResponse()->getContent()));
        $this->assertTrue($client->getResponse()->headers->contains(
            'Content-Type',
            'text/html; charset=UTF-8'
        ));
        $this->assertTrue(strpos($client->getResponse()->getContent(), '2010-01') ? true : false);
    }
}
