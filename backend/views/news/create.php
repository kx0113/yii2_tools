<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\News */

$this->title = '创建';
$this->params['breadcrumbs'][] = ['label' => 'News', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

      <?= $this->render('_form', [
        'type_list'=>$type_list,
        'model' => $model,
    ]) ?>

