<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\FrontMenu */

$this->title = '创建';
$this->params['breadcrumbs'][] = ['label' => 'Front Menus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="front-menu-create">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
