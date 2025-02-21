<?php

namespace Clubdeuce\MapboxPhp\Resources\Search;

use Clubdeuce\MapboxPHP\Helpers\Api;
use Psr\Http\Message\ResponseInterface;

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
            'country'      => null,
            'format'       => 'geojson',
            'limit'        => 5,
            'worldview'    => 'us'
        ));

        $args = array_merge($args, [
            'q'        => $query,
            'access_token' => $this->key()
        ]);

        $args = http_build_query($args);

        $response = $this->get("{$this->endpoint}/forward?{$args}");

        if ($response) {
            $this->response = json_decode($response->getBody()->getContents());
            return $this->response;
        }

        return null;
    }

    function latitude() : float
    {
        if ($this->response->features[0]) {
            return $this->response->features[0]->geometry->coordinates[1];
        }

        trigger_error('Response data is empty', E_USER_ERROR);
    }

    function longitude() : float
    {
        if ($this->response->features[0]) {
            return $this->response->features[0]->geometry->coordinates[0];
        }

        trigger_error('Response data is empty', E_USER_ERROR);
    }
}