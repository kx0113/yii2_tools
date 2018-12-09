<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Signal */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="signal-form">

    <?php $form = ActiveForm::begin(); ?>

<!--    --><?//= $form->field($model, 'types')->textInput() ?>
    <?= $form->field($model, 'types')->dropDownList($types); ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'info')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'desc1')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'desc2')->textarea(['rows' => 6]) ?>

<!--    --><?//= $form->field($model, 'create_time')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
