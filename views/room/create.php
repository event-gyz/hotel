<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Room */

$hotel_id = isset($_GET['hotel_id'])?$_GET['hotel_id']:'';
if(!empty($hotel_id)){
    $hotelInfo = \app\models\Hotel::find()->where(['id'=>$hotel_id])->asArray()->one();
    $hotel_name = $hotelInfo['hotel_name'];
}else{
    $hotel_name='';
}


$this->title = $hotel_name.' 新建房型';
$this->params['breadcrumbs'][] = ['label' => 'Rooms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="room-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
