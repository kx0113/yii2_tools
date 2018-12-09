<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Signal */

$this->title = Yii::t('app', 'Create Signal');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Signals'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="signal-create">


    <div class="wrapper wrapper-content">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <p>
                    <?= Html::encode($this->title) ?>
                </p>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-content">

    <?= $this->render('_form', [
        'model' => $model,
        'types'=>$types,
    ]) ?>

                            </div></div></div></div></div></div></div></div>
