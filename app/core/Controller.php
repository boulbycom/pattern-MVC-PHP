<?php
namespace App\Core;

/**
 * Class Controller
 * @package App\Core
 */
class Controller
{
    protected $layout;
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Permet d'executer l' action appellée
     */
    public function executeAction(){
        if (isset($this->request->params) AND !empty($this->request->params))
        {
            $this->{$this->request->action}($this->request->params);
        }else{
            $this->{$this->request->action}();
        }

    }

    /**
     * @param $view
     * @param null $variables
     * @description : Fait appel à une vue et renvoie les données necessaire pour l'affichage
     */
    public function render($view, $variables = null){
        if (isset($variables)){
            extract($variables);
        }
        ob_start();

        require VIEW_PATH.DS.str_replace('.',  '/', $view).".php";

        $content = ob_get_clean();

        require LAYOUT_PATH.DS.$this->layout.".php";
    }

    /**
     * @param $model_name
     * @description : charge dynamiquement le model appeller par les methodes de controller
     */
    public function loadModel($model_name){
        $classe_model = "\App\Model\\".$model_name."Model";
        $this->{$model_name} = new $classe_model();
    }
}