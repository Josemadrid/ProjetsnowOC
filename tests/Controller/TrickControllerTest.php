<?php


namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TrickControllerTest extends WebTestCase
{
    public function testShow()
    {
        $client = static::createClient();
        $client->request('GET', '/trick/{id}');
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }


    public function testAdd()
    {
        $client = static::createClient();
        $client->request('GET', '/add/trick');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}