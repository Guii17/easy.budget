<?php

namespace Components\Manage\Session;

class ArraySession implements ISession
{
    private $session = [];

    /**
     * Récupère une information en session.
     *
     * @param string  $key
     * @param $default
     *
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        if (array_key_exists($key, $this->session)) {
            return $this->session[$key];
        }

        return $default;
    }

    /**
     * Ajoute une information en session.
     *
     * @param string $key
     * @param $value
     *
     * @return mixed
     */
    public function set(string $key, $value)
    {
        $this->session[$key] = $value;
    }

    /**
     * Supprime.
     *
     * @param string $key
     */
    public function delete(string $key): void
    {
        unset($this->session[$key]);
    }
}
