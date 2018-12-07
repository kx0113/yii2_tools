<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Web;
use common\models\User;
use common\models\NewType;
//use common\models\Web;
//use common\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\News */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'News', 'url' => ['index']];
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
    <p>
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '你确定你要删除这个项目?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'info:raw',
//            'type',
            [
                'attribute' => 'type',
                'format'=>'raw',
                'value'=> NewType::get_type_name($model->type),

            ],

//            'add_user',
//            'create_time:datetime',
            [
                'attribute' => 'create_time',
                'format' => ['date', 'php:Y-m-d H:i:s'],
            ],
            [
                'attribute' => 'update_time',
                'format' => ['date', 'php:Y-m-d H:i:s'],
            ],
//            'update_time:datetime',
            'sort',
            [
                'attribute' => 'add_user',
                'value'=>User::get_username($model->add_user),
            ],
            [
                'attribute' => 'token',
                'value'=>Web::GetWebName($model->token),
            ],
        ],
    ]) ?>

                        </div></div></div></div></div></div></div>
