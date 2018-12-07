<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProductType */

$this->title = '更新: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Product Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="product-type-update">



    <?= $this->render('_form', [
        'model' => $model,
        'type_list'=>$type_list,
    ]) ?>

</div>
