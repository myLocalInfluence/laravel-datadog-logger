<?php

namespace Myli\Testing;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Uri;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\TestCase;
use Monolog\Handler\MissingExtensionException;
use Myli\DatadogLogger\Api\DataDogApiHandler;
use phpmock\phpunit\PHPMock;


/**
 * Class DataDogApiHandlerTest
 *
 * @package   Myli\Testing
 * @author    Aurélien SCHILTZ <aurelien@myli.io>
 * @copyright 2016-2019 Myli
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class DataDogApiHandlerTest extends TestCase
{
    use PHPMock;

    /**
     * Creates the application.
     * Needs to be implemented by subclasses.
     *
     * @return \Symfony\Component\HttpKernel\HttpKernelInterface
     */
    public function createApplication()
    {
        $app = new Application(
            $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
        );

        return $app;
    }

    /**
     * Short description here
     *
     * @return void
     * @throws MissingExtensionException
     */
    public function testExtensionNotLoaded()
    {
        $extensionLoadedFunctionMock = $this->getFunctionMock('\Myli\DatadogLogger\Api', "extension_loaded");
        $extensionLoadedFunctionMock->expects($this->any())->willReturn(false);
        self::expectException(MissingExtensionException::class);
        self::expectExceptionMessage('The curl extension is needed to use the DataDogApiHandler');
        new DataDogApiHandler('faketoken');
    }

    public function testSetHttpClient()
    {
        $dataDogHandler = new DataDogApiHandler('faketoken');
        $mock           = new MockHandler([
            new Response(200, ['X-Foo' => 'Bar']),
        ]);

        $handler      = HandlerStack::create($mock);
        $guzzleClient = new Client(['handler' => $handler]);
        $dataDogHandler->setHttpClient($guzzleClient);
        self::assertEquals($guzzleClient, $dataDogHandler->getHttpClient());
    }


    public function testGetHttpClientNotInitAlready()
    {
        $dataDogHandler = new DataDogApiHandler('faketoken');
        $httpClient     = $dataDogHandler->getHttpClient();
        /**
         * @var Uri $uri
         */
        $uri = $httpClient->getConfig()['base_uri'];
        self::assertEquals(Client::class, get_class($httpClient));
        self::assertEquals('https', $uri->getScheme());
        self::assertEquals('http-intake.logs.datadoghq.com', $uri->getHost());
        self::assertEquals('/v1/input/faketoken', $uri->getPath());
    }

    public function testConfigEuHttpClient()
    {
        $dataDogHandler = new DataDogApiHandler('OneTokenHere!', true);
        $httpClient     = $dataDogHandler->getHttpClient();
        /**
         * @var Uri $uri
         */
        $uri = $httpClient->getConfig()['base_uri'];
        self::assertEquals(Client::class, get_class($httpClient));
        self::assertEquals('https', $uri->getScheme());
        self::assertEquals('http-intake.logs.datadoghq.eu', $uri->getHost());
        self::assertEquals('/v1/input/OneTokenHere!', $uri->getPath());
        self::assertEquals(true, $dataDogHandler->getBubble());
        self::assertEquals(100, $dataDogHandler->getLevel());
        self::assertEquals('eu', $dataDogHandler->getRegion());
        self::assertEquals('OneTokenHere!', $dataDogHandler->getToken());
    }

    public function testConfigUsHttpClient()
    {
        $dataDogHandler = new DataDogApiHandler('TOKEN!', false);
        $httpClient     = $dataDogHandler->getHttpClient();
        /**
         * @var Uri $uri
         */
        $uri = $httpClient->getConfig()['base_uri'];
        self::assertEquals(Client::class, get_class($httpClient));
        self::assertEquals('https', $uri->getScheme());
        self::assertEquals('http-intake.logs.datadoghq.com', $uri->getHost());
        self::assertEquals('/v1/input/TOKEN!', $uri->getPath());
        self::assertEquals(true, $dataDogHandler->getBubble());
        self::assertEquals(100, $dataDogHandler->getLevel());
        self::assertEquals('us', $dataDogHandler->getRegion());
        self::assertEquals('TOKEN!', $dataDogHandler->getToken());
    }

    public function testConfigNoRegionSpecifiedHttpClient()
    {
        $dataDogHandler = new DataDogApiHandler('TOKEN!');
        $httpClient     = $dataDogHandler->getHttpClient();
        /**
         * @var Uri $uri
         */
        $uri = $httpClient->getConfig()['base_uri'];
        self::assertEquals(Client::class, get_class($httpClient));
        self::assertEquals('https', $uri->getScheme());
        self::assertEquals('http-intake.logs.datadoghq.com', $uri->getHost());
        self::assertEquals('/v1/input/TOKEN!', $uri->getPath());
        self::assertEquals(true, $dataDogHandler->getBubble());
        self::assertEquals(100, $dataDogHandler->getLevel());
        self::assertEquals('us', $dataDogHandler->getRegion());
        self::assertEquals('TOKEN!', $dataDogHandler->getToken());
    }

    public function testConfigFileNoConfigExceptApiKey()
    {
        $dataDogHandler = new DataDogApiHandler('TOKEN!');
        $httpClient     = $dataDogHandler->getHttpClient();
        /**
         * @var Uri $uri
         */
        $uri = $httpClient->getConfig()['base_uri'];
        self::assertEquals(Client::class, get_class($httpClient));
        self::assertEquals('https', $uri->getScheme());
        self::assertEquals('http-intake.logs.datadoghq.com', $uri->getHost());
        self::assertEquals('/v1/input/TOKEN!', $uri->getPath());
        self::assertEquals(true, $dataDogHandler->getBubble());
        self::assertEquals(100, $dataDogHandler->getLevel());
        self::assertEquals('us', $dataDogHandler->getRegion());
        self::assertEquals('TOKEN!', $dataDogHandler->getToken());
    }

}
