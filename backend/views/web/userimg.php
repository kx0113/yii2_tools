<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Web */

$this->title = '【'.$name.'】基础图片' ;
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="product-index">
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="components/bootstrap-fileinput-master/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
    <link href="components/bootstrap-fileinput-master/themes/explorer/theme.css" media="all" rel="stylesheet" type="text/css"/>
    <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script src="components/bootstrap-fileinput-master/js/plugins/sortable.js" type="text/javascript"></script>
    <script src="components/bootstrap-fileinput-master/js/fileinput.js" type="text/javascript"></script>
    <script src="components/bootstrap-fileinput-master/js/locales/zh.js" type="text/javascript"></script>
    <!--    <script src="components/bootstrap-fileinput-master/js/locales/es.js" type="text/javascript"></script>-->
    <script src="components/bootstrap-fileinput-master/themes/explorer/theme.js" type="text/javascript"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js" type="text/javascript"></script>
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
                                <br>
                                <p><strong> 用户头像上传</strong><span style="color:#f00;">【仅能上传一张图片，如多次上传将被覆盖，仅支持'jpg', 'png', 'gif'】</span></p>
                                <br>
                                <div class="home_img_call">
                                    <input id="file-0a" class="file" name="logo" type="file" multiple >
                                </div>
                                <br>

                            </div></div></div></div></div></div></div></div>
<?php //echo $data ; ?>
<script>
    // 上传回调
    $(".home_img_call").unbind("fileuploaded");
    $('.home_img_call').bind('fileuploaded', function (event, file, previewId, index, reader) {
        location.reload();
    });


    $("#file-0a").fileinput({
        'theme': 'explorer',
        'uploadUrl': 'index.php?r=web/uploaduserimg',
        overwriteInitial: false,
        maxFileSize: 1000,
        language: "zh",
        browseOnZoneClick:false,
        initialCaption : "单文件上传",
        maxFilesNum: 1,
        initialPreviewAsData: true,
        'allowedFileExtensions': ['jpg', 'png', 'gif'],
        initialPreview: [
            <?php if(!empty($data)){?>
            <?php if(Yii::$app->params['upload_path'] !== $data){echo '"'.$data.'"';} ?>
            <?php } ?>
        ],
        initialPreviewConfig: []
    });

</script>