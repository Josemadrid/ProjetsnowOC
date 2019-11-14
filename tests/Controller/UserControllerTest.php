<?php


namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testRegistration()
    {
        $client = static::createClient();
        $client->request('GET', '/inscription');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testLogin()
    {
        $client = static::createClient();
        $client->request('GET', '/connexion');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}