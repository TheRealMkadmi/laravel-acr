<?php

namespace TheRealMkadmi\LaravelAcr;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class AzureCommunicationClient
{
    protected Client $client;

    protected array $config;

    /**
     * Create a new AzureCommunicationClient instance.
     */
    public function __construct(Client $client, array $config)
    {
        $this->client = $client;
        $this->config = $config;
    }

    /**
     * Sends an email using Azure Communication Services.
     *
     * @param  array  $emailData  The email payload data.
     * @return array The decoded JSON response.
     *
     * @throws \Exception If an error occurs or an invalid response is received.
     */
    public function sendEmail(array $emailData): array
    {
        $endpoint = rtrim($this->config['endpoint'], '/');
        $apiVersion = $this->config['api_version'] ?? '2023-01-15';
        $url = $endpoint.'/emails:send?api-version='.$apiVersion;

        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.$this->config['access_key'],
        ];

        try {
            $response = $this->client->post($url, [
                'headers' => $headers,
                'json' => $emailData,
            ]);

            $body = (string) $response->getBody();
            $decoded = json_decode($body, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Invalid JSON response from Azure Communication Services.');
            }

            return $decoded;
        } catch (GuzzleException $e) {
            throw new \Exception('Error sending email via Azure Communication Services: '.$e->getMessage());
        }
    }
}
