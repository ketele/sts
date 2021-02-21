<?php
namespace App\Services\OntarioBeer\Http;

use Symfony\Contracts\HttpClient\Exception\HttpExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Client
{
    protected $client;

    public function __construct(HttpClientInterface $ontarioBeer)
    {
        $this->client = $ontarioBeer;
    }

    public function getBeers()
    {
        try {
            $response = $this->client->request('GET', '/beers');
            return json_decode($response->getContent());
        } catch(HttpExceptionInterface $e) {

        } catch (TransportExceptionInterface $e) {

        }
    }
}