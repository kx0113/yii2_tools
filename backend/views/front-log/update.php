<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\FrontLog */

$this->title = 'Update Front Log: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Front Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="front-log-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
