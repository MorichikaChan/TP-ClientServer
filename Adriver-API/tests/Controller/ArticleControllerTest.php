<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArticleControllerTest extends WebTestCase {
    
    private $client = null;
  
    public function setUp(): void
    {
      $this->client = static::createClient();
    }
    
    public function testIndex()
    {
        dd();
        $this->client->request('GET', '/article/');
        $this->assertResponseIsSuccessful();
    }
    
    /**
     *  @group current
     */
    public function testCreate()
    {
        dd();
        $this->client->request('POST', '/article/', [
                    'body' => [
                        'title' => 'TestCase1',
                        'leading_body' => 'Lorem',
                        'body' => 'Lorem Ispum',
                        'slug' => 'LoremIspum',
                        'created_by' => 'Max']
                ]);
        $this->assertResponseIsSuccessful();
    }
    
    public function testShow()
    {
        dd();
        $this->client->request('GET', '/article/test');
        $this->assertResponseIsSuccessful();
    }
    
    public function testDelete()
    {
        dd();
        $this->client->request('DELETE', '/article/test');
        $this->assertResponseIsSuccessful();
    }
}
