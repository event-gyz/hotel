<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\Room */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="room-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'room_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'area')->textInput(['maxlength' => true]) ?>
    <?php
    if(isset($_GET['hotel_id'])){
        $hotel_id = $_GET['hotel_id'];
    }else{
        $hotel_id = $model->hotel_id;
    }
    ?>
    <?= $form->field($model, 'hotel_id')->hiddenInput(['value'=>$hotel_id])->label(false) ?>

    <?php
    if(!empty($model->img)){
        ?>
        <div class="form-group">
            <label class="control-label">原房间图片</label>
            <?php
            echo "<img src='{$model->img}' style='width:100px;height:80px;' class=\"form-control\">";
            ?>
        </div>
        <?php
    }
    ?>
    <?= $form->field($model, 'img')->widget(FileInput::classname(), [
        'options' => ['accept' => 'image/*'],
        'pluginOptions' => [
            // 是否显示移除按钮，指input上面的移除按钮，非具体图片上的移除按钮
            'showRemove' => true,
            // 是否显示上传按钮，指input上面的上传按钮，非具体图片上的上传按钮
            'showUpload' => false,
            //是否显示[选择]按钮,指input上面的[选择]按钮,非具体图片上的上传按钮
            'showBrowse' => true,
            // 如果要设置具体图片上的移除、上传和展示按钮，需要设置该选项
            'fileActionSettings' => [
                // 设置具体图片的查看属性为false,默认为true
                'showZoom' => false,
                // 设置具体图片的上传属性为true,默认为true
                'showUpload' => false,
                // 设置具体图片的移除属性为true,默认为true
                'showRemove' => false,
            ],
        ]
    ] );
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '新增' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
