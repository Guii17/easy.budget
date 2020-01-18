<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 16/03/2019
 * Time: 23:33
 */

namespace Application\UsersBundle\Actions;

use Psr\Http\Message\ServerRequestInterface;

class RegisterAction
{

    public function __invoke(ServerRequestInterface $request)
    {
        $string = 'Inscription';
        return $string;
    }
}
