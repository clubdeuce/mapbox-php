<?php

namespace Clubdeuce\MapboxPHP;

/**
 * @method array extra_args()
 */
class Base
{
    protected array $extra_args = [];

    public function __construct(array $args = [])
    {

        foreach ($args as $key => $val) {
            if (property_exists($this, $key)) {
                $this->{$key} = $val;
            } else {
                $this->extra_args[$key] = $val;
            }
        }

    }

    public function __call(string $method, array $args)
    {
        $value = null;

        do {
            if (property_exists($this, $method)) {
                $value = $this->{$method};
                break;
            }
        } while (false);

        return $value;

    }

}
