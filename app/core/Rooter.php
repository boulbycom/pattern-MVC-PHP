<?php

/**
 * Class Rooter
 * @Description : Connecteur de requete et controller.
 */
class Rooter{
    //private static $r;
    protected static $act = array();
    public static $rootes = array();
    private static $prefix = array();
    static $request;

    /***
     * @param $url
     * @param $request
     * @Description : Elle reformate la requete
     * @return mixed
     */
    public static function parse($url, $request)
    {

        if (!is_array($url)){

            $url = trim($url, '/');
        }else if(isset($url['url'])){
            $url=$url['url'];
        }

//        var_dump($url);
//        var_dump($r['catcher']);

        if (empty($url)) {
                $url = self::$rootes[0]['origin'];
            }else{
                $matches = false;
                $request->params = array();
                foreach (self::$rootes as $r) {

                    if(!$matches AND preg_match($r['catcher'], $url, $matches) && $url !==''){
                        $url = $r['origin'];
                        //print_r($matches);
                        foreach ($matches as $k => $v) {
                            // $url = str_replace(":$k", $matches[$k], $r['origin']);
                            if (!is_numeric($k)) {
                                  $url = str_replace(":$k", "$v", $url);
                                  $request->params[$k]=$v;
                            }

                        }

                        $matches = true;

                    }
                }
            }
            //print_r($url);
            //var_dump(self::$rootes);
            //die();
            $url =trim($url,'/');

            $params = explode('/', $url);
            
            if(in_array($params[0], array_keys(self::$prefix))){
                $request->prefix = self::$prefix[$params[0]];
                array_shift($params);
            }
            //print_r($params);
            $request->controller = $params[0];
            $request->action = (isset($params[1])) ? $params[1] : "index";
            if(isset($request->params) AND empty($request->params))
            $request->params = array_slice($params, 2);

            if(isset($request->prefix)){
                $request->action = $request->prefix.'_'.$request->action;
            }
            //print_r($request);
            self::$request = $request;
            
            return $request;

    }

    static function add_prefix($url, $prefix){
        self::$prefix[$url] = $prefix;
    }

    /**
    *Permet de verfiers $url est poster par le visiteur
    ***************************************************/
    public static function is_active($url){
        //print_r($url);
        if(self::$request->url == $url){
            return true;
        }

        return false;
    }

    /**
     *@Description : permet de connecter un url
     *@return : url connect à patcher
     */
    static function connect($redirect, $origin){
        $r = array();

        $r['redir'] =trim($redirect,'/');
        $r['param'] = array();
        $r['catcher'] = trim($redirect,'/');
        $r['url'] = $redirect;
        $r['origin'] = $origin;


        //On rend dynamique, le remplacement des arguments (id, slug, etc) en ayant ?p<paramtere>expression

        $r['originreg'] = preg_replace_callback(
                                    '/([a-z0-9]+):([^\/]+)/', 
                                    // Elle permet de definir les parametre avec le son regex
                                    function ($matches) use (&$r){

                                        $r['param'][$matches[1]] = "(?P<$matches[1]>$matches[2])";

                                        //print_r($r);
                                        // $r['catcher'] = str_replace(':'.$matches[1], "(?P<$matches[1]>$matches[2])", $r['redir']);
                                        // $r['catcher'] = '/'.str_replace('/', '\/', $r['catcher']).'/';
                                        // "$matches[1]:(?P<$matches[1]>$matches[2])";
                                        return "$matches[1]:(?P<$matches[1]>$matches[2])";
                                    }, 

                                    $origin );

            $arr = explode('/', trim($origin));

            $r['controller'] =(count($arr) > 0) ? current($arr) : 'article';
            $r['action'] = (count($arr) > 1) ? next($arr) : 'index';



            if(strpos($redirect, ":")){
                if(preg_match('/([a-z0-9]+):([^\/]+)/', $r['originreg'], $matches)){
                    $r['catcher'] = str_replace(":".$matches[1], $matches[2], $r['catcher']);
                }

            }else{

                $r['catcher'] = $r['catcher'];
            }


            $r['originreg'] = '/'.str_replace('/', '\/', $r['originreg']).'/';

            $r['catcher'] = '/^'.str_replace('/', '\/', $r['catcher']).'$/';



        reset($arr);


        self::$rootes[] = $r;
        //var_dump($r);
    }



    /**
     * @description : permet d'afficher url
     */
    static function url($url){
        //Parcourir le tableau des routes
        $url = trim($url,'/');
        foreach (self::$rootes as $v){
            //Si la valeur existe
            if(preg_match($v['catcher'], $url, $match)){
                foreach ($match as $k => $w) {
                    if(!is_numeric($k)){
                        $v['redir'] = str_replace(":$k", $w, $v['redir']);
                        return ROOT.$v['redir'];
                    }
                }
            }
        }

//    debug(Rooter::$routes);

        foreach (self::$prefix as $k => $v) {
              if(strpos($url, $v) === 0){
                $url = str_replace($v, $k, $url);
              }
          }  

        return ROOT.$url;
    }
    /*************************
    * recpere l'adresse d'une ressource *
    ************************************/

    public static function webroot($url){
            $url = trim($url);
            return ROOT.'public'.DS.$url;
    }

    public static function is_url_valide($url){
            foreach (self::$rootes as $r) {

                foreach ($r['param'] as $glue => $reg) {
                    $r['regexUrl'] = str_replace(":$glue", $reg, $r['redir']);
                    $r['regexUrl'] ='/'.str_replace('/', '\/', $r['regexUrl'] ).'/';
                    if(preg_match("{$r['regexUrl']}i", $url, $matches)){
                    //debug($r);

                       return true;
                    }
                }

        }
        return false;
    }
}