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
                                <p><strong>【<?php echo $name; ?>】网站logo</strong><span style="color:#f00;">【仅能上传一张图片，如多次上传将被覆盖，仅支持'jpg', 'png', 'gif'】</span></p>
                                <br>
                                <div class="home_img_call">
                                    <input id="file-0a" class="file" name="logo" type="file" multiple >
                                </div>
                                <br>
                                <p><strong>【<?php echo $name; ?>】banner图</strong><span style="color:#f00;">【可上传多张图片，仅支持'jpg', 'png', 'gif'】</span></p>
                                <br>
                                <div class="img_list_call">
                                    <input id="kv-explorer" type="file" name="banner" multiple>
                                </div>
                                <?php //echo $id;?>
                                <?php  $img_list=explode(',',$data['banner']); ?>
                            </div></div></div></div></div></div></div></div>

<script>
    // 上传回调
    $(".home_img_call").unbind("fileuploaded");
    $('.home_img_call').bind('fileuploaded', function (event, file, previewId, index, reader) {
        location.reload();
    });

    $(".img_list_call").unbind("fileuploaded");
    $('.img_list_call').bind('fileuploaded', function (event, file, previewId, index, reader) {
        location.reload();
    });

 
    $("#file-0a").fileinput({
        'theme': 'explorer',
        'uploadUrl': 'index.php?r=web/img&par=1&id=<?php echo $data['id'];?>',
        overwriteInitial: false,
        maxFileSize: 1000,
        language: "zh",
        browseOnZoneClick:false,
        initialCaption : "单文件上传",
        maxFilesNum: 1,
        initialPreviewAsData: true,
        'allowedFileExtensions': ['jpg', 'png', 'gif'],
        initialPreview: [
            <?php if(!empty($data['logo'])){?>
            <?php if(Yii::$app->params['upload_path'] !== $data['logo']){echo '"'.$data['logo'].'"';} ?>
            <?php } ?>
        ],
        initialPreviewConfig: []
    });
    $("#kv-explorer").fileinput({
        'theme': 'explorer',
        language: "zh",
        'uploadUrl': 'index.php?r=web/img&par=2&id=<?php echo $data['id'];?>',
        overwriteInitial: false,
        initialPreviewAsData: true,
        'allowedFileExtensions': ['jpg', 'png', 'gif'],
        initialCaption : "多文件上传",
        initialPreview: [
            <?php if(!empty($img_list)){ foreach($img_list as $k=>$v){?>
            <?php if(Yii::$app->params['upload_path'] !== $v){echo '"'.$v.'",';}?>
            <?php } } ?>
        ],
        initialPreviewConfig: [
            <?php if(!empty($img_list)){ foreach($img_list as $k1=>$v1){?>
            <?php if(Yii::$app->params['upload_path'] !== $v1){ echo '{url:"index.php?r=web/product-del-img&id='.$data['id'].'&key='.$k1.'&val='.$v1.'",key:'.$k1.'},';} ?>
            <?php } } ?>
        ]
    });
</script>