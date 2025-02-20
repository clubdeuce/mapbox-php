<?php
namespace Clubdeuce\MapboxPHP\Tests\Unit;

use Clubdeuce\MapboxPHP\Base;
use Clubdeuce\MapboxPHP\Tests\TestCase;

/**
 * @coversDefaultClass \Clubdeuce\MapboxPHP\Base
 */
class TestBase extends TestCase
{
    /**
     * @covers ::__construct
     * @covers ::__call
     */
    public function testConstructor() : void
    {
        $base = new Base([
            'foo'    => 'bar',
            'foobar' => 'baz',
        ]);

        $args = $base->extra_args();

        $this->assertIsArray($args);
        $this->assertArrayHasKey('foo', $args);
        $this->assertArrayHasKey('foobar', $args);
        $this->assertEquals('bar', $args['foo']);
        $this->assertEquals('baz', $args['foobar']);
    }

    public function testParseArgs()
    {
        $base = new Base();
        $args = $base->parse_args([], [
            'foo'    => 'bar',
            'foobar' => 'baz',
        ]);

        $this->assertIsArray($args);
        $this->assertArrayHasKey('foo', $args);
        $this->assertArrayHasKey('foobar', $args);
        $this->assertEquals('bar', $args['foo']);
        $this->assertEquals('baz', $args['foobar']);
    }
}
