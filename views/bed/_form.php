<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Bed */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bed-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?php
    if(isset($_GET['room_id'])){
        $room_id = $_GET['room_id'];
    }else{
        $room_id = $model->room_id;
    }
    ?>
    <?= $form->field($model, 'room_id')->hiddenInput(['value'=>$room_id])->label(false) ?>

    <?= $form->field($model, 'bed_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'breakfast')->textInput() ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '新增' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
