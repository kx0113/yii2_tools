<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ProductType */

$this->title = '创建';
$this->params['breadcrumbs'][] = ['label' => 'Product Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-type-create">



    <?= $this->render('_form', [
        'model' => $model,
        'type_list'=>$type_list,
    ]) ?>

</div>
