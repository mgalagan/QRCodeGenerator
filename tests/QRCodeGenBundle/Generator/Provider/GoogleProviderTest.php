<?php

use \QRCodeGenBundle\Generator\Provider\GoogleProvider;

class GoogleProviderTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $client;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $response;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $stream;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $request;

    /**
     * @var GoogleProvider
     */
    protected $provider;

    public function setUp()
    {
        $this->client = $this->getMockBuilder(\GuzzleHttp\Client::class)
            ->disableOriginalConstructor()
            ->setMethods(['request'])
            ->getMock();

        $this->response = $this->getMockBuilder(\GuzzleHttp\Psr7\Response::class)
            ->disableOriginalConstructor()
            ->setMethods(['getStatusCode', 'getHeader', 'getBody'])
            ->getMock();

        $this->stream = $this->createMock(\Psr\Http\Message\StreamInterface::class);
        $this->request = $this->createMock(\Psr\Http\Message\RequestInterface::class);

        $this->provider = new GoogleProvider();
        $this->provider->setClient($this->client);
    }

    public function testReceiveComplete()
    {
        $this->client->expects($this->once())
            ->method('request')
            ->with($this->equalTo('GET'), $this->equalTo(GoogleProvider::BASE_URL), $this->isType('array'))
            ->willReturn($this->response);

        $this->response->expects($this->once())
            ->method('getStatusCode')
            ->willReturn(200);

        $this->response->expects($this->once())
            ->method('getHeader')
            ->with($this->equalTo('Content-Type'))
            ->willReturn(['image/jpg']);

        $this->response->expects($this->once())
            ->method('getBody')
            ->willReturn($this->stream);

        $this->stream->expects($this->once())
            ->method('getContents')
            ->willReturn('test');

        $data = $this->provider->receive('test', 50, 50);

        $this->assertEquals($data['type'], 'image/jpg');
        $this->assertEquals($data['image'], 'test');
        $this->assertNull($data['error']);
    }

    public function testRecieveException()
    {
        $this->client->expects($this->once())
            ->method('request')
            ->with($this->equalTo('GET'), $this->equalTo(GoogleProvider::BASE_URL), $this->isType('array'))
            ->willThrowException(new \GuzzleHttp\Exception\RequestException('message', $this->request));

        $data = $this->provider->receive('test', 50, 50);
        $this->assertEquals($data['error'], 'message');
    }
}