<?php

namespace Components\Manage\Users;

interface IUser
{
    /**
     * Permet de récupérer le nom d'utilisateur du membre.
     *
     * @return string
     */
    public function getUsername(): string;

    /**
     * Permet de récupérer le rôle du membre.
     *
     * @return string[]
     */
    public function getRoles(): array;
}
