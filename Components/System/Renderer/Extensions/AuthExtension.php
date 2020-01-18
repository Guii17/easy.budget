<?php

namespace Components\System\Renderer\Extensions;

use Components\Manage\Dataspace\Services\Service;
use Components\Manage\Session\ISession;
use Components\System\Dataspace\NoRecordException;

class AuthExtension extends \Twig_Extension
{
    protected $table = "users";
    /**
     * @var ISession
     */
    private $session;
    /**
     * @var Service
     */
    private $service;

    public function __construct(ISession $session, Service $service)
    {
        $this->session = $session;
        $this->service = $service;
    }

    /**
     * @return array
     */
    public function getFunctions(): array
    {
        return [
            new \Twig_SimpleFunction('current_user', [$this, 'getUser']),
        ];
    }

    public function getUser()
    {
        if ($this->session->get('auth.user_id')) {
            $this->user = $this->service->getById($this->session->get('auth.user_id'));
            try {
                $this->user = $this->getBy('username', $this->session->get('auth.user_id'));
                return $this->user;
            } catch(NoRecordException $exception) {
                $this->session->delete('auth.user_id');
                return null;
            }
        }
        return null;
    }
}
