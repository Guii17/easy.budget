<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 16/03/2019
 * Time: 23:40
 */

namespace Application\UsersBundle\Responders;

use Components\Renderer\IRenderer;

class LoginResponder
{
    private $renderer;

    public function __construct(IRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    public function sendLogin($data)
    {
        return $this->renderer->render('@users/login', compact('data'));
    }
}
