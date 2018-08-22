<?php
namespace app\core;
use Yii;

class Permission{
    /**
     * 检测是否有权限
     * @param  string    $url
     * @return boolean          true:有权限,false:无权限
     */
    public static function checkAccess($url=false){
        $modules = strtolower( Yii::$app->controller->module->id );
        if( false == $url ){
            $controller = strtolower( Yii::$app->controller->id );
            $action = strtolower( Yii::$app->controller->action->id );
        }else{
            $urlArr = explode('/',  strtolower($url));
            $controller = $urlArr[0];
            $action = $urlArr[1];
        }
        
        
        $userInfo = Yii::$app->user->identity;
        $permission = Yii::$app->params['permission'][$userInfo->type];
        
        if( 'basic' != $modules ){
            if( !isset( $permission[ $modules ] ) ){
                return false;
            }
            if( in_array('*',$permission[ $modules ]) ){
                return true;
            }
            if( !isset($permission[ $modules ][ $controller ]) ){
                return false;
            }
            if( in_array('*',$permission[ $modules ][ $controller ]) ){
                return true;
            }
            if( in_array($action,$permission[ $modules ][ $controller ]) ){
                return true;
            }
            return false;
        }else{
            if( !isset( $permission[ $controller ] ) ){
                return false;
            }
            if( in_array('*',$permission[ $controller ]) ){
                return true;
            }
            if( in_array($action,$permission[ $controller ]) ){
                return true;
            }
            return false;
        }
        
    }
}
