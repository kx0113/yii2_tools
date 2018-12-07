<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Web;
use common\models\User;
use common\models\Product;
use common\models\ProductType;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-view">

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

    <p>
        <?= Html::a('图片上传', ['upload', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
<!--        --><?//= Html::a('删除', ['delete', 'id' => $model->id], [
//            'class' => 'btn btn-danger',
//            'data' => [
//                'confirm' => '你确定你要删除这个项目吗?',
//                'method' => 'post',
//            ],
//        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
//            'img_list:ntext',
//            'type',
            [
                'attribute' => 'type',
                'format'=>'raw',
                'value'=> ProductType::get_type_name($model->type),

            ],
//            'home_img',
            'info',
            'text:raw',
//            'add_time',
            [
                'attribute' => 'add_time',
                'format' => ['date', 'php:Y-m-d H:i:s'],
            ],
//            'add_user',
            [
                'attribute' => 'add_user',
                'value'=>!empty($model->add_user) ? User::get_username($model->add_user) :'',
            ],
//            'update_time',
            [
                'attribute' => 'update_time',
                'format' => ['date', 'php:Y-m-d H:i:s'],
            ],
//            'token',
            [
                'attribute' => 'token',
                'value'=>Web::GetWebName($model->token),
            ],


        ],
    ]) ?>

                            </div></div></div></div></div></div></div></div>
