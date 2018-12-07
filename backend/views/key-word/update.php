<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\KeyWord */

$this->title = '更新: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Key Words', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="key-word-update">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
