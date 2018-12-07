<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\Web;
use common\models\User;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ConfigSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '站点配置';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="config-index">
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
//            'token',
            [
                'attribute' => 'token',
                'value'=>
                    function($model){
                        return Web::GetWebName($model->token);
                    },
            ],
            'models',
            'params',
            'limit',
//            'add_user',
            [
                'attribute' => 'add_user',
                'value'=>
                    function($model){
                        return User::get_username($model->add_user);
                    },
            ],
            [
                'attribute' => 'add_time',
                'value'=>
                    function($model){
                        if(!empty($model->add_time)){
                            return Yii::$app->formatter->asDate($model->add_time,"php:Y-m-d H:i:s");
                        }
                    }

            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div></div></div></div></div></div></div>
