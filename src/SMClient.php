<?php

namespace SESMonitor;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class SMClient
{
    private $client;
    private $apiKey;
    private $baseURL;
    private $version;

    public function __construct($apiKey)
    {
        $this->client = new Client();
        $this->apiKey = $apiKey;
        $this->version = "v1";
        $this->baseURL = "https://api.sesmonitor.com/api/" . $this->version;
    }

    public function setVersion(string $version)
    {
        if(!in_array($version, ["v1"]))
            throw new \Exception("Invalid version");
    }

    public function listDomains(int $paginationPage = 1, int $paginationPerPage = 25, array $queryParams = []): array
    {
        return $this->makeRequest('POST', '/domains/list', $paginationPage, $paginationPerPage, $queryParams);
    }

    public function getDomain(array $queryParams = []): array
    {
        return $this->makeRequest('POST', '/domains/get', null, null, $queryParams);
    }

    public function listMessages(int $paginationPage = 1, int $paginationPerPage = 25, array $queryParams = []): array
    {
        return $this->makeRequest('POST', '/messages/list', $paginationPage, $paginationPerPage, $queryParams);
    }

    public function getMessage(array $queryParams = []): array
    {
        return $this->makeRequest('POST', '/messages/get', null, null, $queryParams);
    }

    private function makeRequest(string $method, string $endpoint, ?int $paginationPage, ?int $paginationPerPage, array $queryParams): array
    {
        try {
            $response = $this->client->request($method, $this->baseURL . $endpoint, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Accept' => 'application/json',
                ],
                'json' => [
                    'page' => $paginationPage,
                    'per_page' => $paginationPerPage,
                    'query' => $queryParams,
                ]
            ]);

            // Grab the body contents
            $body = $response->getBody();
            $content = $body->getContents();

            // JSON decode and back out
            return json_decode($content, true);
        } catch (RequestException $e) {
            // Rethrow it
            throw $e;
        } catch (\Exception $e) {
            // Rethrow it
            throw $e;
        }
    }
}