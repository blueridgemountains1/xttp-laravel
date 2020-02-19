<?php

namespace JohnathanSmith\XttpLaravel\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use JohnathanSmith\XttpLaravel\Xttp;
use JohnathanSmith\XttpLaravel\XttpLaravel;
use Psr\Http\Message\ResponseInterface;

class XttpLaravelTest extends TestCase
{
    /**
     * @test
     * @dataProvider methodProvider
     */
    public function it_will_return_client(string $method)
    {
        $container = [];
        $url = 'https://johnathansmith.com';
        $bodyArray = ['Johnathan' => 'Smith'];
        $jsonString = json_encode($bodyArray);
        $header = ['Foo' => 'Bar'];

        $mockHandler = new MockHandler([
            new Response(200, $header, $jsonString),
        ]);

        $stack = new HandlerStack($mockHandler);
        $stack->push(Middleware::history($container));
        $client = new Client([
            'handler' => $stack,
        ]);

        /** @var \JohnathanSmith\Xttp\XttpResponse $r */
        $r = Xttp::{$method}($url, [], $client);

        $this->assertEquals($r->json(), $bodyArray);
        $this->assertEquals($r->body(), $jsonString);

        $this->assertEquals($header, $r->headers());
        $this->assertEquals($header['Foo'], $r->header('Foo'));

        $this->assertTrue(true);

        $this->assertInstanceOf(ResponseInterface::class, $r->getResponse());

        $this->assertInstanceOf(ResponseInterface::class, $container[0]['response']);
    }

    public function methodProvider()
    {
        return [
            'post' => ['post'],
            'get' => ['get'],
            'put' => ['put'],
            'patch' => ['patch'],
            'delete' => ['delete'],
        ];
    }

    /** @test */
    public function can_add_macro()
    {
        $url = 'https://johnathansmith.com';

        XttpLaravel::macro('testing', function () use ($url) {
            return $url;
        });

        $this->assertTrue(Xttp::hasMacro('testing'));

        $this->assertEquals($url, Xttp::testing());

    }

    /** @test */
    public function can_create_pending()
    {
        /** @var \JohnathanSmith\Xttp\XttpPending $pending */
        $pending = Xttp::pending();
        $bodyArray = ['Johnathan' => 'Smith'];
        $jsonString = json_encode($bodyArray);

        $mockHandler = new MockHandler([
            new Response(200, [], $jsonString),
        ]);

        $r = $pending->setMethod('POST')
            ->setUrl('https://johnathansmith.com/xttp')
            ->withMock($mockHandler)
            ->send();

        $this->assertEquals($bodyArray, $r->json());
        $this->assertEquals($jsonString, $r->body());

    }
}
