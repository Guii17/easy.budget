<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 19/01/2019
 * Time: 22:12
 */

namespace Application\Home\Actions;


use Application\Home\Repositories\HomeRepository;
use Application\Home\Responders\HomeResponder;

class HomeIndex
{
    /**
     * @var HomeResponder
     */
    private $tutorialsResponder;

    /**
     * @var HomeRepository
     */
    private $tutorialsRepository;

    public function __construct(
        HomeResponder $homeResponder,
        HomeRepository $homeRepository
    )
    {
        $this->homeResponder = $homeResponder;
        $this->homeRepository = $homeRepository;
    }


    /**
     * La fonction invoke permet d'appeller une ou plusieurs fonctions en tant qu'objet
     *
     * @param Request $request
     * @return string
     */
    public function __invoke()
    {
        $data = [];
        return $this->homeResponder->index($data);
    }
}