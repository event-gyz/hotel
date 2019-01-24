<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '订单管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
<!--        --><?//= Html::a('Create Order', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label'=>'酒店名称',
//                'filter' => Html::activeDropDownList(
//                    $searchModel,
//                    'gender',
//                    $searchModel::$hotel_id,['class' => 'form-control']),
                'value'=>
                    function($model){
                        $hotel_id = $model->hotel_id;
                        $hotelInfo = \app\models\Hotel::find()->where(['id'=>$hotel_id])->asArray()->one();
                        return $hotelInfo['hotel_name'];

                    },
            ],
            [
                'label'=>'房型名称',
//                'filter' => Html::activeDropDownList(
//                    $searchModel,
//                    'gender',
//                    $searchModel::$hotel_id,['class' => 'form-control']),
                'value'=>
                    function($model){
                        $room_id = $model->room_id;
                        $roomInfo = \app\models\Room::find()->where(['id'=>$room_id])->asArray()->one();
                        return $roomInfo['room_name'];
                    },
            ],
            [
                'label'=>'床型名称',
//                'filter' => Html::activeDropDownList(
//                    $searchModel,
//                    'gender',
//                    $searchModel::$hotel_id,['class' => 'form-control']),
                'value'=>
                    function($model){
                        $bed_id = $model->bed_id;
                        $bedInfo = \app\models\Bed::find()->where(['id'=>$bed_id])->asArray()->one();
                        return $bedInfo['bed_name'];
                    },

            ],
            'num',
            'name',
            'content_name',
            'content_phone',
            [
                'label'=>'是否拼房',
                'value'=>
                    function($model){

                        if($model->is_pinfang == 1){
                            if($model->sex == 1){
                                $sex = '男';
                            }else{
                                $sex = '女';
                            }
                            return '拼房('.$sex.')';
                        }else{
                            return '不拼房';
                        }
                    },
            ],
            [
                'label'=>'入住时间',
                'value'=>
                    function($model){
                        $check_in_time = explode(' ',$model->check_in_time);
                        return $check_in_time['0'];
                    },
            ],
            [
                'label'=>'离店时间',
                'value'=>
                    function($model){
                        $check_out_time = explode(' ',$model->check_out_time);
                        return $check_out_time['0'];
                    },
            ],
            [
                'label'=>'订单金额',
                'value'=>'total_price'
            ],
            [
                'label'=>'支付状态',
                'value'=>
                    function($model){
                        switch ($model->pay_status){
                            case 0:
                                return '未支付';
                                break;
                            case 1:
                                return '已支付';
                                break;
                            default:
                                return '';
                        }
                    },
            ],
            [
                'label'=>'下单时间',
                'value'=>'create_time'
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'buttons' => [
                    'view' => function($url, $model, $key) {
                        return Html::a('查看', $url);
                    },
                    'update' => function($url, $model, $key) {
                        return Html::a('编辑', $url);
                    },
                    'delete' => function($url, $model, $key) {
                        $options = [
                            'data-pjax' => 0,
                            'data-confirm' => '您确定要删除此项吗？',
                            'data-method' => 'post',
                        ];
//                        return Html::a('删除', $url, $options);
                    }

                ],
                'headerOptions'=>['class' => 'text-center','style'=>'10%'],
                'header' => Yii::t('app', ''),
            ],
        ],
    ]); ?>
</div>
