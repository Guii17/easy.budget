<?php

namespace Application\Home\Responders;

use Components\Renderer\RendererInterface;

class HomeResponder
{

    private $renderer;

    public function __construct(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    public function index($data)
    {
        return $this->renderer->render('@home/index', compact('data'));
    }
}