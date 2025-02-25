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
            'key'   => MAPBOX_TEST_KEY
        ]);

        $result = $geocoder->forward('1600 Pennsylvania Ave NW Washington DC');

        $this->assertIsObject($result);
        $this->assertObjectHasProperty('features', $result);
        $this->assertIsArray($result->features);
        $this->assertCount(5, $result->features);
    }

    /**
     * @covers ::forward
     * @depends testForward
     */
    public function testForwardLimit()
    {
        $geocoder = new Geocoder([
            'key'   => MAPBOX_TEST_KEY,
        ]);

        $result = $geocoder->forward('1600 Pennsylvania Ave NW Washington DC', ['limit' => 2]);

        $this->assertCount(2, $result->features);
    }

    /**
     * @covers ::forwardStructuredInput
     */
    public function testForwardStructuredInput()
    {
        $geocoder = new Geocoder([
            'key'   => MAPBOX_TEST_KEY,
        ]);

        $address = [
            'address_number' => '1600',
            'street'         => 'Pennsylvania Ave NW',
            'place'          => 'Washington DC',
            'postcode'       => '20502',
            'country'        => 'us'
        ];

        $result = $geocoder->forwardStructuredInput($address);

        $this->assertIsObject($result);
        $this->assertObjectHasProperty('features', $result);
        $this->assertIsArray($result->features);
        $this->assertCount(1, $result->features);

        foreach($result->features as $feature) {
            $this->assertObjectHasProperty('geometry', $feature);
            $this->assertIsArray($feature->geometry->coordinates);
        }
    }

    /**
     * @covers ::forwardStructuredInput
     */
    public function testForwardStructuredInputCombined()
    {
        $geocoder = new Geocoder([
            'key'   => MAPBOX_TEST_KEY,
        ]);

        $address = [
            'address_line1' => '1600 Pennsylvania Ave NW',
            'place'         => 'Washington DC',
            'postcode'      => '20502',
            'country'       => 'us'
        ];

        $result = $geocoder->forwardStructuredInput($address);

        $this->assertIsObject($result);
        $this->assertObjectHasProperty('features', $result);
        $this->assertIsArray($result->features);
        $this->assertCount(1, $result->features);

        foreach($result->features as $feature) {
            $this->assertObjectHasProperty('geometry', $feature);
            $this->assertIsArray($feature->geometry->coordinates);
            $this->assertGreaterThan(0, $geocoder->latitude());
            $this->assertLessThan(0, $geocoder->longitude());
        }
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

    /**
     * @covers ::longitude
     * @depends testForward
     */
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