<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\WapBuds;
use app\models\WapHeight;
use app\models\WapWeight;
use Yii;
use yii\console\Controller;
use app\models\Users;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ShellController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex()
    {
        $allUser = Users::find()->asArray()->all();
        foreach($allUser as $key=>$value){
            $birthday = new \DateTime($value['birth_day']);
            $diff = $birthday->diff(new \DateTime());
            $months = $diff->format('%m') + 12 * $diff->format('%y');
            $days = $diff->format('%d');
            if($days >= 15)
                $months += 0.5;
            $user_age = $months;
            $re = $this->getPercent($value['uid'],$user_age,$value['birth_day'],$value['supervisor_uid']);
            Users::updateAll($re,['uid'=>$value['uid']]);
        }



    }
    private function getPercent($user_uid,$user_age,$birth_day,$supervisor_uid){

//        $user_age = $_SESSION['CURRENT_KID_AGE'];
        $start_age = $user_age-1;
        $end_age = $user_age+1;
//        $user_uid = $_SESSION["CURRENT_KID_UID"];
        $result = [];

        for($i=0;$i<6;$i++){
            $sql = "select count(*) as cc from grow_index left join grow_log as log on log.item_uid=grow_index.uid where ((grow_index.age_min >= '$start_age' and grow_index.age_min<= '$end_age') or (grow_index.age_max <= '$end_age' and grow_index.age_max >= '$start_age')) and user_uid=$user_uid and grow_index.type=$i";

            $res = Yii::$app->db->createCommand($sql)
                ->queryOne();
            if(empty($res)){
                $res['cc'] = 0;
            }
            $sql = "select count(*) as cc from grow_index where ((grow_index.age_min >= '$start_age' and grow_index.age_min<= '$end_age') or (grow_index.age_max <= '$end_age' and grow_index.age_max >= '$start_age')) and grow_index.type=$i";
            $re = Yii::$app->db->createCommand($sql)
                ->queryOne();
            if(empty($re)){
                $re['cc'] = 0;
            }
            @$result['type_'.$i] =  round($res['cc']/$re['cc'],2)*100;
        }


        $result['weight_index'] = $this->weightIndex($user_uid,$birth_day);
        $result['height_index'] = $this->heightIndex($user_uid,$birth_day);
        $result['buds_index']   = $this->budsIndex($birth_day,$supervisor_uid);
        return $result;

    }

    public function weightIndex($user_uid,$birth_day){
        $weight = WapWeight::find()->where(['uid'=>$user_uid])->orderBy(['date' => SORT_DESC])->asArray()->one();
        if(empty($weight) || !is_array($weight)){
            return 100;
        }
        $birthday = new \DateTime($birth_day);
        $diff = $birthday->diff(new \DateTime($weight['date']));
        $months = $diff->format('%m') + 12 * $diff->format('%y');
        $days = $diff->format('%d');
        if($days >= 15)
            $months += 0.5;
        $age = $months;
        $userWeight=  $weight['weight'];
        $shouldWeight = 0;
        if($age>=1 && $age<7){
            $shouldWeight = 3+$age*0.6;
        }else if($age>=7 && $age<13){
            $shouldWeight = 3+$age*0.5;
        }else if($age>=13 && $age<=120){
            $shouldWeight = $age/6+7;
        }

        if($shouldWeight == 0){
            return 100;
        }
        $per = round($userWeight/$shouldWeight,2)*100;
        return $per;

    }

    public function heightIndex($user_uid,$birth_day){
        $height = WapHeight::find()->where(['uid'=>$user_uid])->orderBy(['date' => SORT_DESC])->asArray()->one();
        if(empty($height) || !is_array($height)){
            return 100;
        }
        $birthday = new \DateTime($birth_day);
        $diff = $birthday->diff(new \DateTime($height['date']));
        $months = $diff->format('%m') + 12 * $diff->format('%y');
        $days = $diff->format('%d');
        if($days >= 15)
            $months += 0.5;
        $age = $months;
        $userHeight=  $height['height'];
        $shouldHeight = 0;
        if($age>=1 && $age<7){
            $shouldHeight = 3+$age*0.6;
        }else if($age>=7 && $age<13){
            $shouldHeight = 3+$age*0.5;
        }else if($age>=13 && $age<=120){
            $shouldHeight = $age/6+7;
        }

        if($shouldHeight == 0){
            return 100;
        }
        $per = round($userHeight/$shouldHeight,2)*100;
        return $per;
    }

    public function budsIndex($birth_day,$supervisor_uid){
        $buds = WapBuds::find()->where(['uid'=>$supervisor_uid])->orderBy(['date' => SORT_ASC])->asArray()->one();
        if(empty($buds) || !is_array($buds)){
            return 0;
        }
        $birthday = new \DateTime($birth_day);
        $diff = $birthday->diff(new \DateTime($buds['date']));
        $months = $diff->format('%m') + 12 * $diff->format('%y');
        $days = $diff->format('%d');
        if($days >= 15)
            $months += 0.5;
        $age = $months;
        if($age<4){
            return 9;
        }else if($age>=4 && $age<9){
            return 10;
        }else{
            return 11;
        }
    }
}
