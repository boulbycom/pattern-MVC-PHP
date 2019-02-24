<?php
namespace App\Core;

use App\Classes\Database;

/**
 * Class Model
 * @package App\Core
 */
class Model{
    protected $pdo;
    protected $entity;

    public function __construct()
    {
        $this->pdo = Database::getPDO();
    }

    /***
     * @param $params
     * @param array $options
     * @Description permet de chercher une info dans la bd
     */
    public function find($params, $options=[]){
        $req = "SELECT ";

        if(isset($params['fields'])){
            if (is_array($params['fields'])){
               $req .= implode(', ',$params['fields']);
            }else{
                $req .= $params['fields'];

            }
        }else{
            $req .=" * ";
        }

        $req .=" FROM $this->entity ";

        if(isset($params['conditions']) AND !empty($params['conditions'])){
            $req .=" WHERE ";
            $cond = [];

            foreach($params['conditions'] as $key => $value){
                if (is_numeric($value)){
                    $cond[] = "$key=$value";
                }else{
                    $cond[] = "$key='$value'";
                }
            }

            $req .= implode(' AND ', $cond);
        }

        if(isset($params['limit'])){
            $req .=" LIMIT {$params['limit']}";
        }

        $data = $this->pdo->query($req)->fetchAll(\PDO::FETCH_OBJ);
        return $data;
    }
}