<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
//AppAsset::register($this);
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $this->title; ?></title>
    <meta name="description" content="<?php echo $this->description; ?>" />
    <meta name="keywords" content="<?php echo $this->keywords; ?>" />
    <script src="js/jquery-1.js" type="text/javascript"></script>
    <?php $this->head(); ?>
</head>
<body>
<?php $this->beginBody(); ?>
<?= $content ?>
<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>
