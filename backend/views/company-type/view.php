<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Web;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\CompanyType */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Company Types', 'url' => ['index']];
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
                'confirm' => '你确定你要删除这个项目吗?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'sort',
//            'token',
//            'create_at',
            [
                'attribute' => 'create_at',
                'format' => ['date', 'php:Y-m-d H:i:s'],
//                'value'=>Yii::$app->formatter->asDate($model->create_time,"php:Y-m-d H:i:s"),
            ],
//            'user_id',
            [
                'attribute' => 'user_id',
                'value'=>User::get_username($model->user_id),
            ],
            [
                'attribute' => 'token',
                'value'=>Web::GetWebName($model->token),
            ],
        ],
    ]) ?>

                        </div></div></div></div></div></div></div>
