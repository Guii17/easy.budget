<?php

namespace Components\Manage\Session;

interface ISession
{
    /**
     * Récupère une information en session.
     *
     * @param string  $key
     * @param $default
     *
     * @return mixed
     */
    public function get(string $key, $default);

    /**
     * Ajoute une information en session.
     *
     * @param string $key
     * @param $value
     *
     * @return mixed
     */
    public function set(string $key, $value);

    /**
     * Supprime.
     *
     * @param string $key
     */
    public function delete(string $key): void;
}
