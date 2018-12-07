<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\FrontLog */

$this->title = 'Create Front Log';
$this->params['breadcrumbs'][] = ['label' => 'Front Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="front-log-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
