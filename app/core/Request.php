<?php
namespace App\Core;

/**
 * Class Request
 * @package App\Core
 * @Description : 1er Interface avec les visiteurs,
 * elle encapsule, reformule et normalise l'ensemble des infos sur requete.
 */
class Request
{
    public $controller;
    public $action;
    public $params;
    public $url;

    /**
     * Request constructor.
     * @param $url
     */
    public function __construct($url)
    {
        $this->url=$url;
        if (isset($url) AND !empty($url)) {

            $urlTab = explode("/", $url['url']);

            if (!empty($urlTab)) {
                $this->controller = ucfirst(current($urlTab)) . 'Controller';
                $this->action = next($urlTab);
                $this->params = [];

                return;
            }
        }
        
        $this->controller = "PostController";
        $this->action = "index";
        $this->params = [];

    }
}