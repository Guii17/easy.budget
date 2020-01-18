<?php

use Application\UsersBundle\Services\UserService;
use Components\Database\IAuthentificate;

return [
    'users.prefix' => '/private_space',
    IAuthentificate::class => \Di\get(UserService::class)

];
