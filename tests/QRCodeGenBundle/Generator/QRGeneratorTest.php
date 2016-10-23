<?php

class QRGeneratorTest extends \PHPUnit_Framework_TestCase
{
    public function testGenerate()
    {
        $provider = $this->createMock(\QRCodeGenBundle\Generator\Provider\ProviderInterface::class);
        $provider->expects($this->once())
            ->method('receive')
            ->with($this->equalTo($text = 'test'), $this->equalTo($width = 50), $this->equalTo($height = 50))
            ->willReturn(true);

        $code = new \QRCodeGenBundle\Entity\QRCode();
        $code->setText($text)->setHeight($height)->setWidth($width);

        $generator = new \QRCodeGenBundle\Generator\QRGenerator();
        $generator->setProvider($provider);

        $this->assertTrue($generator->generate($code));
    }
}