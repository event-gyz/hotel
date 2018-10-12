<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Room */

$this->title = $model->room_name.' 房型信息';
$this->params['breadcrumbs'][] = ['label' => 'Rooms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="room-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('修改房型信息', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除房型信息', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '是否要删除该数？',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
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
        ],
    ]) ?>

</div>
