<?php

namespace Components\System\Renderer\Extensions;

use Components\System\Middlewares\CsrfMiddleware;

class CsrfExtension extends \Twig_Extension
{
    private $csrfMiddleware;

    public function __construct(CsrfMiddleware $csrfMiddleware)
    {
        $this->csrfMiddleware = $csrfMiddleware;
    }

    /**
     * @return \Twig_SimpleFilter[]
     */
    public function getFunctions(): array
    {
        return [
            new \Twig_SimpleFunction('csrf_input', [$this, 'csrfInput'], ['is_safe' => ['html']]),
        ];
    }

    public function csrfInput()
    {
        return '<input type="hidden" name="'.$this->csrfMiddleware->getFormKey().'" value="'.$this->csrfMiddleware->generateToken().'" />';
    }
}
