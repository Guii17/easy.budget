<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 16/03/2019
 * Time: 23:40
 */

namespace Application\HomeBundle\Responders;

use Components\System\Renderer\IRenderer;

class HomepageResponder
{
    /**
     * @var IRenderer
     */
    private $renderer;

    /**
     * HomepageResponder constructor.
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
    public function sendHome($data)
    {
        return $this->renderer->render('@home/index', compact('data'));
    }
}
