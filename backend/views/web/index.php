<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\WebSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '网站列表';
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
                                <?= Html::a('创建', ['create'], ['class' => 'btn btn-success']) ?>
                            </p>
                            <?php Pjax::begin(); ?>    <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                'filterModel' => $searchModel,
                                'layout' => '{items}{summary}{pager}',
                                'columns' => [
                                    ['class' => 'yii\grid\SerialColumn'],
                                    'id',
                                    'name',
                                    'weburl',
                                    'status',
                                    'version',
                                    'sort',
                                    ['class' => 'yii\grid\ActionColumn',
                                        'template' => '{view} {update}{delete}{web-config}',
                                        'buttons' => [
                                            'web-config' => function ($url, $model) {
                                                return Html::a(Yii::t('app',''), $url,[
                                                    'class'=>'glyphicon glyphicon-cog',
                                                    'title' => Yii::t('app', '配置网站'),
                                                    'style'=>'margin: 0 0 0 5px',
                                                ]);},
                                        ],
                                    ],
          ],
    ]); ?>
                            <?php Pjax::end(); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
