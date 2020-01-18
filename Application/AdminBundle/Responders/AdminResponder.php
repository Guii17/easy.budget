<?php

namespace Application\AdminBundle\Responders;

use Components\System\Renderer\IRenderer;

class AdminResponder
{
    /**
     * @var IRenderer
     */
    private $renderer;

    /**
     * AdminResponder constructor.
     *
     * @param IRenderer $renderer
     */
    public function __construct(IRenderer $renderer)
    {

        $this->renderer = $renderer;
    }

    /**
     * @param  $data
     * @return string
     */
    public function sendAdmin($data)
    {
        return $this->renderer->render('@admin/index', compact('data'));
    }
}
