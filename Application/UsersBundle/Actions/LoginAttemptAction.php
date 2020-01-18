<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 16/03/2019
 * Time: 23:33
 */

namespace Application\UsersBundle\Actions;

use Application\Auth\Domain\AuthService;
use Application\UsersBundle\Responders\LoginResponder;
use Components\Manage\Actions\RouterAwareAction;
use Components\Router\Router;
use Components\Session\ISession;
use Psr\Http\Message\ServerRequestInterface;

class LoginAttemptAction
{

    private $responder;

    private $service;

    private $router;

    private $session;

    use RouterAwareAction;

    /**
     * LoginAction constructor.
     *
     * @param LoginResponder $responder
     * @param AuthService    $service
     * @param Router         $router
     * @param ISession       $session
     */
    public function __construct(
        LoginResponder $responder,
        AuthService $service,
        Router $router,
        ISession $session
    ) {
        $this->responder = $responder;
        $this->service = $service;
        $this->router = $router;
        $this->session = $session;
    }

    /**
     * @return string
     */
    public function __invoke(ServerRequestInterface $request)
    {
        $params = $request->getParsedBody();
        $user = $this->service->loginAccount($params['username'], $params['password']);
        if ($user) {
            (new FlashService($this->session))->success('Content de vous revoir '.ucfirst($user->username));
            $path = $this->session->get('auth.redirect') ? $this->session->get('auth.redirect') : 'home.index';
            $this->session->delete('auth.redirect');

            return $this->redirect($path);
        } else {
            (new FlashService($this->session))->error('Identifiant ou mot de passe incorrect !');
        }

        return $this->responder->readLogin($data = null);
    }
}
