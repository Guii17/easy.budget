<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 16/03/2019
 * Time: 23:33
 */

namespace Application\HomeBundle\Actions;

use Application\HomeBundle\Responders\HomepageResponder;

class HomepageAction
{

    /**
     * @var AdminResponder
     */
    private $responder;

    public function __construct(HomepageResponder $responder)
    {
        $this->responder = $responder;
    }

    public function __invoke()
    {
        return $this->responder->sendHome($data = null);
    }
}
