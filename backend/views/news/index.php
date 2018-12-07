<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\Web;
use common\models\User;
use common\models\NewType;

/* @var $this yii\web\View */
/* @var $searchModel app\models\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '文章列表';
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
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

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
//            'name',
            [
                'attribute' => 'name',
                'value'=>
                    function($searchModel){
                        return mb_substr($searchModel->name,0,15,'utf-8');
                    },
            ],
//            'info:ntext',
            'show_time',
            [
            'attribute' => 'type',
            'value'=>
                function($model){
                    return NewType::get_type_name($model->type);
                },
        ],
//            'add_user',
            [
                'attribute' => 'create_time',
                'value'=>
                    function($model){
                        if(!empty($model->create_time)){
                            return Yii::$app->formatter->asDate($model->create_time,"php:Y-m-d H:i:s");
                        }
                    }
            ],
            // 'create_time:datetime',
            [
                'attribute' => 'add_user',
                'value'=>
                    function($model){
                        return User::get_username($model->add_user);
                    },
            ],
            // 'update_time:datetime',
            // 'sort',
            // 'token',
            [
                'attribute' => 'token',
                'value'=>
                    function($model){
                        return Web::GetWebName($model->token);
                    },
            ],
            ['class' => 'yii\grid\ActionColumn'],

        ],
    ]); ?>
<?php Pjax::end(); ?></div></div></div></div></div></div></div>
