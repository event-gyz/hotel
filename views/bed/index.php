<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BedSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '床型管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bed-index">

    <h1><?= Html::encode($this->title) ?></h1>
<!--    --><?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加床型', '/bed/create?room_id='.$_GET['room_id'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'bed_name',
            'breakfast',
            'price',
            'create_time',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
                'buttons' => [
                    'view' => function($url, $model, $key) {
                        return Html::a('查看', $url);
                    },
                    'update' => function($url, $model, $key) {
                        return Html::a('编辑', $url);
                    },
                ],
                'headerOptions'=>['class' => 'text-center','style'=>'10%'],
                'header' => Yii::t('app', ''),
            ],
        ],
    ]); ?>
</div>
