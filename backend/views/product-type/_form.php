<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProductType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-type-form">
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
                                <div class="form-group field-producttype-parent">
                                    <label class="control-label" for="producttype-parent">一级分类</label>
<select id="producttype-parent" class="form-control" name="ProductType[parent]">
<!--    <option value="0">一级分类</option>-->
    <?php var_dump($model->parent);foreach($type_list as $k1=>$v1){?>
    <option <?php if($model->parent==$k1){ echo 'selected' ;}?> value="<?php echo $k1; ?>"><?php echo $v1; ?></option>
    <?php } ?>
</select>
                                    </div>
<!--    --><?//= $form->field($model, 'parent')->dropDownList($type_list); ?>
    <?= $form->field($model, 'info')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

                            </div></div></div></div></div></div></div></div>
