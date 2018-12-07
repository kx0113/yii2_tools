<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CompanyType */

$this->title = '创建';
$this->params['breadcrumbs'][] = ['label' => 'Company Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="company-type-create">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
