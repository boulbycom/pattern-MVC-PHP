<?php
namespace App\Core;

/**
 * Class Dispatcher
 * @package App\Core
 * @description : Controller factory, elle cree à la volé le controller appeller par la requete
 */
class Dispatcher{

    /**
     * Dispatcher constructor.
     */
    public function __construct()
    {
        $this->request = new Request($_GET);
        \Rooter::parse($this->request->url, $this->request);
//        var_dump($this->request);
//        die();
    }


    /**
     * @return mixed
     * @description: controller factory action.
     */
    public function buildController(){
        $controllerName = "\App\Controller\\".ucfirst($this->request->controller).'Controller';
        return new $controllerName($this->request);
    }
}