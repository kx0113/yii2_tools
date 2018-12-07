<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Web */

$this->title = '创建';
$this->params['breadcrumbs'][] = ['label' => 'Webs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="web-create">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
