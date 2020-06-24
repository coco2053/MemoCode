<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;

class GouvApi
{
    public function getCities(string $postCode)
    {
        $cities = array();
        $client = HttpClient::create();
        $response = $client->request('GET', 'https://geo.api.gouv.fr/communes?codePostal=' . $postCode);
        $content = json_decode($response->getContent());
        foreach ($content as $c) {
            $c = json_decode(json_encode($c), true);
            $cities [] = $c["nom"];
        }
        return $cities;
    }
}