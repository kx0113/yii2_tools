<?php

use yii\helpers\Html;

use yii\widgets\DetailView;
use common\models\Web;
use common\models\User;
use common\models\CompanyType;

/* @var $this yii\web\View */
/* @var $model app\models\Company */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Companies', 'url' => ['index']];
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
<?// echo html_entity_decode('<p>123</p>');?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'info',
            [
                'attribute' => 'type',
                'format'=>'raw',
                'value'=> CompanyType::get_type_name($model->type),

            ],
            'content:raw',
//            'add_user',
            [
                'attribute' => 'add_user',
                'value'=>User::get_username($model->add_user),
            ],
            [
                'attribute' => 'create_time',
                'format' => ['date', 'php:Y-m-d H:i:s'],
//                'value'=>Yii::$app->formatter->asDate($model->create_time,"php:Y-m-d H:i:s"),
            ],
//            'create_time:datetime',
            [
                'attribute' => 'update_time',
                'format' => ['date', 'php:Y-m-d H:i:s'],
            ],
//            'update_time:datetime',

            [
                'attribute' => 'token',
                'value'=>Web::GetWebName($model->token),
            ],

//            'type',
        ],
    ]) ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
