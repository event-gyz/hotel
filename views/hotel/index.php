<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\HotelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '酒店管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hotel-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('新增酒店', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'hotel_name',
            'hotel_address',
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
            'distances',
            // 'create_time',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {insert_room}',
                'buttons' => [
                    'view' => function($url, $model, $key) {
                        return Html::a('查看', $url);
                    },
                    'update' => function($url, $model, $key) {
                        return Html::a('编辑', $url);
                    },
                    'insert_room' => function($url, $model, $key) {
                        return Html::a('房型管理', '/room/index?hotel_id='.$model->id);
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
