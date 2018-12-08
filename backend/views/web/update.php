<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Web */

$this->title = '更新: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Webs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="web-update">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
