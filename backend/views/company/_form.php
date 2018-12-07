<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Company */
/* @var $form yii\widgets\ActiveForm */
?>


<style type="text/css">
    div{
        width:100%;
    }
    </style>
<div class="company-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'type')->dropDownList($type_list); ?>
    <?= $form->field($model, 'info')->textarea(['rows' => 6]) ?>
    <p><b>内容</b></p>
    <div id="editor" name="Company[content]" style="width:1024px;height:500px;">

    </div>

    <br><br>
<!--    --><?//= $form->field($model, 'type')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script type="text/javascript">
    window.onload=function(){
        setContent();
    };
    var ue = UE.getEditor('editor');
    function setContent() {
        UE.getEditor('editor').setContent('<?php if(!empty($model->content)) echo $model->content; ?>');
    }
    function test(){
        setContent();
    }
    var t1=setTimeout("test()",1000);


</script>