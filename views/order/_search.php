<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\OrderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'content_name') ?>

    <?= $form->field($model, 'content_phone') ?>

    <?= $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'is_invoice') ?>

    <?php // echo $form->field($model, 'invoice_type') ?>

    <?php // echo $form->field($model, 'invoice_title') ?>

    <?php // echo $form->field($model, 'invoice_address') ?>

    <?php // echo $form->field($model, 'invoice_name') ?>

    <?php // echo $form->field($model, 'invoice_phone') ?>

    <?php // echo $form->field($model, 'check_in_time') ?>

    <?php // echo $form->field($model, 'check_out_time') ?>

    <?php // echo $form->field($model, 'total_price') ?>

    <?php // echo $form->field($model, 'hotel_id') ?>

    <?php // echo $form->field($model, 'room_id') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
