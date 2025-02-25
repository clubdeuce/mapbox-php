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
        $args = $this->parse_args($args, array(
            'permanent'    => $this->permanent_storage,
            'autocomplete' => false,
            'bbox'         => null,
            'country'      => null,
            'format'       => 'geojson',
            'language'     => null,
            'limit'        => 5,
            'proximity'    => null,
            'types'        => null,
            'worldview'    => 'us'
        ));

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
}