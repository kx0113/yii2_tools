<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\NewType */

$this->title = '创建';
$this->params['breadcrumbs'][] = ['label' => 'New Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="new-type-create">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
