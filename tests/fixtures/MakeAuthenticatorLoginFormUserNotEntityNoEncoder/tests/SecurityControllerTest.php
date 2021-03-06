<?php

namespace App\Tests;

use App\Security\AppCustomAuthenticator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    public function testCommand()
    {
        $authenticatorReflection = new \ReflectionClass(AppCustomAuthenticator::class);
        $constructorParameters = $authenticatorReflection->getConstructor()->getParameters();
        $this->assertSame('router', $constructorParameters[0]->getName());

        // assert authenticator is *not* injected
        $this->assertEquals(2, \count($constructorParameters));

        $client = self::createClient();
        $crawler = $client->request('GET', '/login');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $form = $crawler->filter('form')->form();
        $form->setValues(
            [
                'email'    => 'bar',
                'password' => 'foo',
            ]
        );
        $client->submit($form);

        $this->assertContains('TODO: check the credentials', $client->getResponse()->getContent());
    }
}
