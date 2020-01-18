<?php
/**
 * Created by PhpStorm.
 * User: Guillaume & Audrey
 * Date: 02/01/2020
 * Time: 09:12
 */

namespace Application\UsersBundle\Services;


use Components\Database\IAuthentificate;
use Components\Manage\Users\IUser;

class UserService implements IAuthentificate
{

    /**
     * @return IUser|null
     */
    public function getUser(): ?IUser
    {
        return null;
    }
}
