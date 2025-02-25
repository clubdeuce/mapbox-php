<?php

namespace Clubdeuce\MapboxPhp\Resources\Search;

use Clubdeuce\MapboxPHP\Helpers\Api;

/**
 * @method object response()
 */
class Geocoder extends Api
{
    protected string $endpoint = '/search/geocode/v6';
    protected object $response;
    protected bool $permanent_storage = false;

    /**
     * Perform a forward lookup, i.e. text address to lat/lng
     */
    public function forward(string $query, array $args = array()): mixed
    {
        $args = $this->parse_args($args, $this->default_args());

        $args = array_merge($args, [
            'q'        => $query,
            'access_token' => $this->key()
        ]);

        $query_string = http_build_query(array_filter($args));

        $response = $this->get("{$this->endpoint}/forward?{$query_string}");

        if ($response) {
            $this->response = json_decode($response->getBody()->getContents());
            return $this->response;
        }

        return null;
    }

    /**
     * @param array $address
     * @param array $args
     * @return object|null
     *
     * @link https://docs.mapbox.com/api/search/geocoding/#forward-geocoding-with-structured-input
     */
    public function forwardStructuredInput(array $address, array $args = array()) : ?object
    {
        $args    = $this->parse_args($args, $this->default_args());
        $address = $this->parse_args($address, [
            'address_line1'  => null,
            'address_number' => null,
            'street'         => null,
            'block'          => null,
            'place'          => null,
            'region'         => null,
            'postcode'       => null,
            'locality'       => null,
            'neighborhood'   => null,
            'country'        => null,
        ]);

        if (!empty($address['address_line1'])) {
            unset($address['address_number']);
            unset($address['street']);
        }

        $args = array_merge($address, $args);
        $args = array_merge($args, [
            'access_token' => $this->key()
        ]);

        $query_string = http_build_query(array_filter($args));

        $response = $this->get("{$this->endpoint}/forward?{$query_string}");

        if ($response) {
            $this->response = json_decode($response->getBody()->getContents());
            return $this->response;
        }

        return null;
    }

    public function latitude() : ?float
    {
        if ($this->response->features[0]) {
            return $this->response->features[0]->geometry->coordinates[1];
        }

        trigger_error('Response data is empty', E_USER_ERROR);
    }

    public function longitude() : ?float
    {
        if ($this->response->features[0]) {
            return $this->response->features[0]->geometry->coordinates[0];
        }

        trigger_error('Response data is empty', E_USER_ERROR);
    }

    public function default_args() : array
    {
        return [
            'permanent'    => $this->permanent_storage,
            'autocomplete' => false,
            'bbox'         => null,
            'format'       => 'geojson',
            'language'     => null,
            'limit'        => 5,
            'proximity'    => null,
            'types'        => null,
            'worldview'    => null,
        ];
    }
}