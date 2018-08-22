<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Bed */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bed-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'bed_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'breakfast')->textInput() ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '新增' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
