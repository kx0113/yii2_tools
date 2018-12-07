<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\Web;
use common\models\User;
use common\models\ProductType;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '产品列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

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
        'layout' => '{items}{summary}{pager}',
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
//            'name',
            [
                'attribute' => 'name',
                'value'=>
                    function($searchModel){
                        return mb_substr($searchModel->name,0,10,'utf-8');
                    },
            ],
//            'type',
            [
                'attribute' => 'type',
                'value'=>
                    function($searchModel){
                        return mb_substr(ProductType::get_type_name($searchModel->type),0,10,'utf-8');
                    },
            ],

//            'home_img',
            //'info',
  
//             'add_time',
            [
                'attribute' => 'add_time',
                'value'=>
                    function($model){
                        if(!empty($model->add_time)){
                            return Yii::$app->formatter->asDate($model->add_time,"php:Y-m-d H:i:s");
                        }
                    }
            ],

            [
                'attribute' => 'add_user',
                'value'=>
                    function($model){
                        return User::get_username($model->add_user);
                    },
            ],
//             'add_user',
            [
                'attribute' => 'update_time',
                'value'=>
                    function($model){
                        if(!empty($model->update_time)){
                            return Yii::$app->formatter->asDate($model->update_time,"php:Y-m-d H:i:s");
                        }
                    }
            ],
//             'update_time',
    //             'token',
            [
                'attribute' => 'token',
                'value'=>
                    function($model){
                        return Web::GetWebName($model->token);
                    },
            ],

//            ['class' => 'yii\grid\ActionColumn'],
            [
                'class' => 'yii\grid\ActionColumn',
//                'header' => '操作',
                'options' => ['width' => '100px;'],
                'template' => '{view} {update}{delete}{upload}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a(Yii::t('app',''), $url, [
                            'title' => Yii::t('app', '查看'),
//                            'style'=>'margin: 0 5px 0 0 ',
                            'class'=>'glyphicon glyphicon-eye-open',
                        ]);
                    },
                    'update' => function ($url, $model) {
                        return Html::a(Yii::t('app',''), $url, [
                            'title' => Yii::t('app', '更新'),
                            'class'=>'glyphicon glyphicon-pencil',
                        ]);
                    },

                    'delete' => function ($url, $model) {
                        return Html::a(Yii::t('app',''), $url, [
                            'title' => Yii::t('app', '删除'),
                            'class'=>'glyphicon glyphicon-trash',
                        ]);
                    },
                     'upload' => function ($url, $model) {
                         return Html::a(Yii::t('app',''), $url,[
                             'class'=>'glyphicon glyphicon-picture',
                             'title' => Yii::t('app', '图片上传'),
                             'style'=>'margin: 0 0 0 5px',
                         ]);},
                ],

            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div></div></div></div></div></div></div></div>
