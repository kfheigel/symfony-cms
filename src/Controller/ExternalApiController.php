<?php

namespace App\Controller;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ExternalApiController extends AbstractController
{
    /**
     * @Route("/external/api", name="external_api")
     */
    public function index()
    {
        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', 'https://api.covid19api.com/summary');

        if (200 !== $response->getStatusCode()) {
        } else {
            $content = json_decode($response->getContent(), true);
            $content = $content['Countries'];
        }

        return $this->render('external_api/index.html.twig', [
            'api_data' => $content,
        ]);
    }
}
