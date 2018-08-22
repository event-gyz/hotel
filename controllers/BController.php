<?php
/**
 * Created by PhpStorm.
 * User: chunyang
 * Date: 16/7/3
 * Time: 下午4:40
 */
namespace app\controllers;

use Yii;
use yii\web\Controller;

class BController extends Controller
{
    public $user_id;

    public function __construct($id, $module, $config = []) {
        parent::__construct($id, $module, $config = []);
        if (Yii::$app->user->isGuest) {
            header('Location: /site/login');
            exit;
        }
    }
    
    public function beforeAction($action) {
        parent::beforeAction($action);
        $permission =  \app\core\Permission::checkAccess();
        
        if( !$permission ){
            throw new \yii\web\HttpException(403, "You don't have permission to access on this server.");
        }
        return true;
    }
    
    public function array_to_json( $data=[] ){
        header("Content-type:application/json");
        echo json_encode( $data );
        exit;
    }
    
    public function filterArray( $columns=[],$data=[] ){
        if( empty($data) || empty($columns) ){
            return null;
        }
        $res = [];
        foreach( $data as $key=>$value ){
            if( in_array( $key, $columns) ){
                $res[$key] = $value;
            }
        }
        return $res;
    }
}
