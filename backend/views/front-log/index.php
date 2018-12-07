<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Web;

/* @var $this yii\web\View */
/* @var $searchModel common\models\FrontLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '访问日志';
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
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout' => '{items}{summary}{pager}',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
//            'url:url',
//            'time:datetime',
            [
                'attribute' => 'time',
                'format' => ['date', 'php:Y-m-d H:i:s'],
            ],

            'ip',
            'action',
            'msg',
            'area',
            'area2',
            [
                'attribute' => 'token',
                'value'=>
                    function($model){
                        return Web::GetWebName($model->token);
                    },
            ],
//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
                        </div></div></div></div></div></div></div>
