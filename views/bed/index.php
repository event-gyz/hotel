<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BedSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Beds';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bed-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Bed', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'bed_name',
            'breakfast',
            'price',
            'create_time',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
