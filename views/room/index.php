<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RoomSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$hotel_id = isset($_GET['hotel_id'])?$_GET['hotel_id']:'';
if(!empty($hotel_id)){
    $hotelInfo = \app\models\Hotel::find()->where(['id'=>$hotel_id])->asArray()->one();
    $hotel_name = $hotelInfo['hotel_name'];
}else{
    $hotel_name='';
}


$this->title = $hotel_name.'房型管理';

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="room-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加房型', '/room/create?hotel_id='.$_GET['hotel_id'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'room_name',
            'area',
            [
                'attribute' => 'img',
                'value' => function($model){
                    if(!empty($model->img)){
                        $avatar = $model->img;
                        return "<img src='{$avatar}' style='max-height:50px;max-width:50px'>";
                    }else{
                        return '';
                    }
                },
                'format'=>'raw',
            ],

            'hotel_id',

            // 'create_time',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {bed} {delete}',
                'buttons' => [
                    'view' => function($url, $model, $key) {
                        return Html::a('查看', $url);
                    },
                    'update' => function($url, $model, $key) {
                        return Html::a('编辑', $url);
                    },
                    'bed' => function($url, $model, $key) {
                        return Html::a('床型管理', '/bed/index?room_id='.$model->id);
                    },
                    'delete' => function($url, $model, $key) {
                        $options = [
                            'data-pjax' => 0,
                            'data-confirm' => '您确定要删除此项吗？',
                            'data-method' => 'post',
                        ];
                        return Html::a('删除', $url, $options);
                    }

                ],
                'headerOptions'=>['class' => 'text-center','style'=>'10%'],
                'header' => Yii::t('app', ''),
            ],
        ],
    ]); ?>
</div>
