<?php
namespace QRCodeGenBundle\Generator;

use GuzzleHttp\Client;
use QRCodeGenBundle\Entity\QRCode;
use QRCodeGenBundle\Generator\Provider\ProviderInterface;

class QRGenerator
{
    /**
     * @var ProviderInterface
     */
    protected $provider;

    /**
     * set client for better testing
     * @param ProviderInterface $provider
     */
    public function setProvider(ProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    /**
     * @param QRCode $code
     * @return array
     */
    public function generate(QRCode $code)
    {
        return $this->provider->receive($code->getText(), $code->getWidth(), $code->getHeight());

    }
}