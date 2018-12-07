<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = '创建';
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-create">



    <?= $this->render('_form', [
        'type_list'=>$type_list,
        'model' => $model,
    ]) ?>

</div>
