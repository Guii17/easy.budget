<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 16/03/2019
 * Time: 23:33
 */

namespace Application\AdminBundle\Actions;

use Application\AdminBundle\Responders\AdminResponder;
use Components\System\Base\BaseBundle;

class AdminAction extends BaseBundle
{

    /**
     * @var AdminResponder
     */
    private $responder;

    public function __construct(AdminResponder $responder)
    {
        $this->responder = $responder;
    }

    public function __invoke()
    {
        return $this->responder->sendAdmin($data = null);
    }
}
