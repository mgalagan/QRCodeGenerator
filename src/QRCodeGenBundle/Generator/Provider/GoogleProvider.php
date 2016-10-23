<?php
namespace QRCodeGenBundle\Generator\Provider;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class GoogleProvider implements ProviderInterface
{
    const BASE_URL = 'https://chart.googleapis.com/chart';

    /**
     * @var Client
     */
    protected $client;

    /**
     * @inheritdoc
     */
    public function setClient(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @inheritdoc
     */
    public function receive($text, $width, $height)
    {
        $result = [
            'type' => '',
            'image' => '',
            'error' => null,
        ];
        $response = null;
        try {
            $response = $this->client->request('GET', self::BASE_URL, ['query' => [
                'cht' => 'qr',
                'chl' => $text,
                'chs' => sprintf('%dx%d', $width, $height),
            ]]);
        } catch (RequestException $e) {
            $result['error'] = $e->getMessage();
        }

        if ($response && $response->getStatusCode() == 200) {
            $result['type'] = $response->getHeader('Content-Type')[0];
            $result['image'] = $response->getBody()->getContents();
        }

        return $result;
    }
}