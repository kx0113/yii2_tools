<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\KeyWord */

$this->title = '创建';
$this->params['breadcrumbs'][] = ['label' => 'Key Words', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="key-word-create">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
