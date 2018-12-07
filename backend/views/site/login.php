<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Y+后台管理系统';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    body{background: #fff}
</style>
<div class="middle-box text-center loginscreen  animated fadeInDown">
     <img src="./img/108108.png" />
    <div style="margin:30px 0 0 0;" class="panel panel-default">
    <div style="width:100%;padding: 20px 40px 10px 40px;">

    <div class="row">

        <div class="">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('用户名') ?>

                <?= $form->field($model, 'password')->passwordInput()->label('密码') ?>



                <div class="form-group">
                    <?= Html::submitButton('登陆', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div></div>

    </div>
    <div class="">
        <br>
        <br>
        <div class="">青岛凯旋信息科技有限公司<br>
            © 2009-2018 www.kaixuans.com<br>
            版权所有 ICP证：鲁ICP备17041765号<br>
        </div>
    </div>
</div>



