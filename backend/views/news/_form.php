<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\News */
/* @var $form yii\widgets\ActiveForm */
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

<div class="news-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'remark')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'type')->dropDownList($type_list); ?>
   <p><b>内容</b></p>
    <div id="editor" name="News[info]" style="width:1024px;height:500px;">

    </div>

    <br><br>
<!--    --><?//= $form->field($model, 'info')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'show_time')->textInput() ?>
        <p>示例：2017-10-10</p><br>

    <?= $form->field($model, 'sort')->textInput() ?>



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div></div></div></div></div></div></div></div>
<script type="text/javascript">
    window.onload=function(){
        setContent();
    };
    var ue = UE.getEditor('editor');
    function setContent() {
        UE.getEditor('editor').setContent('<?php  if(!empty($model->info)) echo $model->info; ?>');
    }
    function test(){
        setContent();
    }
    var t1=setTimeout("test()",1000);


</script>
