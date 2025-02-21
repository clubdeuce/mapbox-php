<?php

namespace Clubdeuce\MapboxPHP\Tests\Integration;

use Clubdeuce\MapboxPhp\Resources\Search\Geocoder;
use Clubdeuce\MapboxPHP\Tests\TestCase;

/**
 * @coversDefaultClass \Clubdeuce\MapboxPhp\Resources\Search\Geocoder
 */
class TestGeocdoer extends TestCase
{
    /**
     * @covers ::forward
     */
    public function testForward()
    {
        $geocoder = new Geocoder([
            'key' => MAPBOX_TEST_KEY
        ]);

        $result = $geocoder->forward('1600 Pennsylvania Ave NW Washington DC');

        $this->assertIsObject($result);
    }

    /**
     * @covers ::latitude
     * @depends testForward
     */
    public function testLatitude()
    {
        $geocoder = new Geocoder([
            'key' => MAPBOX_TEST_KEY
        ]);

        $geocoder->forward('1600 Pennsylvania Ave NW Washington DC');
        $this->assertIsFloat($geocoder->latitude());
        $this->assertGreaterThan(0, $geocoder->latitude());
    }

    public function testLongitude()
    {
        $geocoder = new Geocoder([
            'key' => MAPBOX_TEST_KEY
        ]);

        $geocoder->forward('1600 Pennsylvania Ave NW Washington DC');
        $this->assertIsFloat($geocoder->longitude());
        $this->assertLessThan(0, $geocoder->longitude());
    }
}