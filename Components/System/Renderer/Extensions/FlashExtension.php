<?php

namespace Components\System\Renderer\Extensions;

use Components\Manage\Session\FlashService;

class FlashExtension extends \Twig_Extension
{
    /**
     * @var FlashService
     */
    private $flash;

    /**
     * FlashExtension constructor.
     *
     * @param FlashService $flash
     */
    public function __construct(FlashService $flash)
    {
        $this->flash = $flash;
    }

    public function getFunctions(): array
    {
        return [
            new \Twig_SimpleFunction('flash', [$this, 'getFlash']),
        ];
    }

    public function getFlash($type): ?string
    {
        return $this->flash->get($type);
    }
}
