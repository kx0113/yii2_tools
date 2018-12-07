<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\NewType */

$this->title = '更新: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'New Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="new-type-update">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
