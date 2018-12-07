<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\FrontMenu */

$this->title = '更新: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Front Menus', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="front-menu-update">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
