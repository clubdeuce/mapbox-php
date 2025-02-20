<?php
namespace Clubdeuce\MapboxPHP\Tests\Unit;

use Clubdeuce\MapboxPHP\Helpers\Api;
use Clubdeuce\MapboxPHP\Tests\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\MockObject\Exception;
use Psr\Http\Message\ResponseInterface;
use ReflectionMethod;

/**
 * @coversDefaultClass \Clubdeuce\MapboxPHP\Helpers\Api
 */
class TestApi extends TestCase
{
    /**
     * @covers ::default_args
     * @return void
     * @throws \ReflectionException
     */
    public function testDefaultArgs()
    {
        $reflection = new ReflectionMethod(Api::class, 'default_args');
        $reflection->setAccessible(true);
        $result = $reflection->invoke(new Api());

        $this->assertIsArray($result);
        $this->assertArrayHasKey('headers', $result);
        $this->assertIsArray($result['headers']);
        $this->assertArrayHasKey('Accept', $result['headers']);
        $this->assertArrayHasKey('body', $result);
    }

    public function testGet()
    {
        try {
            $http = $this->createMock(Client::class);
            $api = new Api(['http' => $http]);
            $result = $api->get('/test');
            $this->assertInstanceOf(ResponseInterface::class, $result);
        } catch (GuzzleException|Exception $e) {
            trigger_error($e->getMessage(), E_USER_ERROR);
        }
    }

    public function testPost()
    {
        try {
            $http = $this->createMock(Client::class);
            $api = new Api(['http' => $http]);
            $result = $api->post('/test');
            $this->assertInstanceOf(ResponseInterface::class, $result);
        } catch (Exception $e) {
            trigger_error($e->getMessage(), E_USER_ERROR);
        }
    }
}