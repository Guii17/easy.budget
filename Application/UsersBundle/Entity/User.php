<?php
/**
 * Created by PhpStorm.
 * User: Guillaume & Audrey
 * Date: 02/01/2020
 * Time: 09:10
 */

namespace Application\UsersBundle;


use Components\Manage\Users\IUser;

class User implements IUser
{

    public $id;
    
    public $username;

    public $email;

    public $password;

    /**
     * Permet de récupérer le nom d'utilisateur du membre.
     *
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Permet de récupérer le rôle du membre.
     *
     * @return string[]
     */
    public function getRoles(): array
    {
        return [];
    }
}
