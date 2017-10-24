<?php

namespace Tests\AppBundle\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Newsletter Subscription Form', $crawler->filter('.container h1')->text());
    }

    public function testICannotSubmitEmptyDatas()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
        $form = $crawler->selectButton('Submit')->form();
        $client->submit($form);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertRegexp(
        '/This value should not be blank/',
                $client->getResponse()->getContent()
        );
    }

    public function testICannotSubmitWrongEmail()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
        $form = $crawler->selectButton('Submit')->form();
        $form['appbundle_user[email]'] = 'test@gmail.fr';
        $form['appbundle_user[lastName]'] = 'test';
        $client->submit($form);

        $this->assertRegexp(
        '/is not a valid email./',
            $client->getResponse()->getContent()
        );
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testSuccess()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/success');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Success', $crawler->filter('body h1')->text());
    }
}
