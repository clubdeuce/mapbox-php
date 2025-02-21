<?php

namespace Clubdeuce\MapboxPHP\Helpers;

use Clubdeuce\MapboxPHP\Base;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 * @method string base_route()
 * @method Client http()
 * @method string key()
 */
class Api extends Base
{

    protected string $base_route = "https://api.mapbox.com";
    protected Client $http;
    protected string $key;

    public function __construct($args = array())
    {

        $args = $this->parse_args($args, array(
            'http' => new Client(),
        ));

        parent::__construct($args);

    }

    public function get(string $endpoint, array $args = array())
    {
        $args = $this->parse_args($args, $this->default_args());

        try {
            return $this->http->request('GET', "{$this->base_route()}{$endpoint}", $args);
        } catch (GuzzleException $e) {
            trigger_error($e->getMessage(), E_USER_ERROR);
        }
    }

    public function post(string $endpoint, array $args = array())
    {
        $args = $this->parse_args($args, $this->default_args());

        try {
            return $this->http->request('POST', "{$this->base_route()}{$endpoint}", $args);
        } catch (GuzzleException $e) {
            trigger_error($e->getMessage(), E_USER_ERROR);
        }
    }

    protected function default_args() : array
    {
        return [
            'headers' => [
                'Accept' => 'application/json',
            ]
        ];
    }
}
