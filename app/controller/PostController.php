<?php
namespace App\Controller;


/**
 * Class PostController
 * @package App\Controller
 */
class PostController extends AppController {

    public function __construct($request)
    {
        parent::__construct($request);
    }

    /**
     * @description : methode appelé lorsque le visiteur se rend sur la page d'accueil
     */
    public function index(){

        $this->loadModel('Post');

        $posts = $this->Post->find(['fields'=>'id, name, content', 'limit'=>'5']);


        $this->render('post.index', compact('posts'));

    }

    /**
     * @param $params
     * @description : Elle permet d'afficher un post à travers son ID
     */
    public function show($params){
        if(is_array($params) ){
            $id = $params['id'];
        }else{
            $id = $params;

        }

        $this->loadModel('Post');
        $conditions = [
            'id'=> $id,
            'posted'=> 1
        ];

        $post = $this->Post->find(['conditions'=>$conditions, 'fields'=>'id, name, content'])[0];

        if(!empty($post)){
            $this->render('post.show', compact('post'));
        }else{
            die('Url not find');

        }
    }

}