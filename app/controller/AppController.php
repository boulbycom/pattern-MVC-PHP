<?php
namespace App\Controller;

use App\Core\Controller;

/**
 * Class AppController
 * @package App\Controller
 */
class AppController extends Controller{
    /**
     * AppController constructor.
     * @param $request
     */
    public function __construct($request)
    {
        $this->layout = 'template';

        parent::__construct($request);
    }

    /**
     *
     */
    public function index(){

        $this->render('post.index');
    }
}