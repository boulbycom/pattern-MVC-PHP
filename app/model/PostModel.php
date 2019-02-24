<?php
namespace App\Model;

use App\Core\Model;

class PostModel extends Model{

    public function __construct()
    {
        $this->entity = 'posts';
        parent::__construct();
    }
}