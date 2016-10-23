<?php
namespace QRCodeGenBundle\Generator\Provider;

use GuzzleHttp\Client;

interface ProviderInterface
{
    /**
     * set client
     * @param Client $client
     * @return void
     */
    public function setClient(Client $client);

    /**
     * receive image
     * @param $text
     * @param $width
     * @param $height
     * @return array
     */
    public function receive($text, $width, $height);
}