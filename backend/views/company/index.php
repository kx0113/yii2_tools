<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\Web;
use common\models\User;
use common\models\CompanyType;
/* @var $this yii\web\View */
/* @var $searchModel app\models\CompanySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '项目列表';
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


<div class="company-index">


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
            'title',
//            'type',
            [
                'attribute' => 'type',
                'value'=>
                    function($model){
                        return CompanyType::get_type_name($model->type);
                    },
            ],

//            'content:ntext',get_username
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
            [
                'attribute' => 'add_user',
                'value'=>
                    function($model){
                        return User::get_username($model->add_user);
                    },
            ],

//            'create_time:datetime',
            // 'update_time:datetime',
//              'token',
            [
                'attribute' => 'token',
                'value'=>
                    function($model){
                        return Web::GetWebName($model->token);
                    },
            ],
            // 'type',get_web_name

            ['class' => 'yii\grid\ActionColumn'],

        ],
    ]); ?>
<?php Pjax::end(); ?></div></div></div></div></div></div></div></div>
