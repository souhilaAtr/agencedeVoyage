<?php

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{


    public function testIndex()
    {
        $client = static::createClient();
        // Effectue une requête GET vers la route de la page d'accueil
        $crewler = $client->request('GET', '/');
        // vérifie que la réponse HTTP est réussie (code de réponse 200)

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        // vérifie que le contenu de la page contient le message "bienvenue sur la page d'accueil

        $this->assertStringContainsString('Bienvenue sur la page d\'accueil', $crewler->filter('h1')->text());
    }
}
