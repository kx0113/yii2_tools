<?php
//use backend\assets\AppAsset;
use yii\helpers\Html;


use yii\widgets\ActiveForm;
use kartik\file\FileInput;
//use kartik\widgets\FileInput
/* @var $this yii\web\View */
/* @var $model app\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">
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
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                                <?= $form->field($model, 'type')->dropDownList($type_list); ?>
<!--    --><?//= $form->field($model, 'img_list')->textarea(['rows' => 6]) ?>

<!--    --><?//= $form->field($model, 'home_img')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'info')->textarea(['rows' => 6]) ?>
                                <p><b>内容</b></p>
                                <div id="editor" name="Product[text]" style="width:1024px;height:500px;">
                                  <div style="display: none;" > <?php echo !empty($model->text)?$model->text: '' ; ?></div>
                                </div>

                                <br><br>
                                <?= $form->field($model, 'sort')->textInput(['maxlength' => true]) ?>
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
        UE.getEditor('editor').setContent('<?php  if(!empty($model->text)) echo $model->text; ?>');
    }
    function test(){
        setContent();
    }
    var t1=setTimeout("test()",1000);


</script>