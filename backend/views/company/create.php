<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Company */

$this->title = 'Create Company';
$this->params['breadcrumbs'][] = ['label' => 'Companies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
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
        'type_list'=>$type_list,
        'model' => $model,
    ]) ?>

                        </div></div></div></div></div></div></div>
