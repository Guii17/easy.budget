<?php

namespace Components\Manage\Dataspace\Authentificate;


use Components\Manage\Users\IUser;

interface IAuthentificate
{

    /**
     * @return IUser|null
     */
    public function getUser(): ?IUser;

}
