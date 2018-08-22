<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Order */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content_phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_invoice')->textInput() ?>

    <?= $form->field($model, 'invoice_type')->textInput() ?>

    <?= $form->field($model, 'invoice_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'invoice_address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'invoice_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'invoice_phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'check_in_time')->textInput() ?>

    <?= $form->field($model, 'check_out_time')->textInput() ?>

    <?= $form->field($model, 'total_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'hotel_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'room_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
