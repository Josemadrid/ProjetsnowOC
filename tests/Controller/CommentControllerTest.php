<?php


namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CommentControllerTest extends WebTestCase
{
    public function testAddComment()
    {
        $client = static::createClient();
        $client->request('GET','/comment');
        $this->assertEquals(500, $client->getResponse()->getStatusCode());
    }

    public function testAllComments()
    {
        $client = static::createClient();
        $client->request('GET', '/allcomments/{id}');
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }
}