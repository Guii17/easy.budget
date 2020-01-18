<?php

namespace Components\Manage\Dataspace\Authentificate;

use Components\Manage\Users\IUser;

class DataAuthentificate implements IAuthentificate
{

    /**
     * Permet de récupérer un membre.
     *
     * @return IUser|null
     */
    public function getUser(): ?IUser
    {
        return null;
    }

    /**
     * Permet de vérifier si un utilisateur est connecté.
     */
    public function getLoggedIn()
    {
        // TODO: Implement getLoggedIn() method.
    }
}
