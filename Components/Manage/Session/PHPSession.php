<?php

namespace Components\Manage\Session;

class PHPSession implements ISession, \ArrayAccess
{
    /**
     * Vérifie si la session est démarré.
     */
    private function ensureStarted()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

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
        $this->ensureStarted();
        if (array_key_exists($key, $_SESSION)) {
            return $_SESSION[$key];
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
        $this->ensureStarted();
        $_SESSION[$key] = $value;
    }

    /**
     * Supprime.
     *
     * @param string $key
     */
    public function delete(string $key): void
    {
        $this->ensureStarted();
        unset($_SESSION[$key]);
    }

    public function offsetExists($offset)
    {
        $this->ensureStarted();

        return array_key_exists($offset, $_SESSION);
    }

    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    public function offsetSet($offset, $value)
    {
        return $this->set($offset, $value);
    }

    public function offsetUnset($offset)
    {
        return $this->delete($offset);
    }
}
