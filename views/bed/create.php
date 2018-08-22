<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Bed */

$this->title = 'Create Bed';
$this->params['breadcrumbs'][] = ['label' => 'Beds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bed-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
