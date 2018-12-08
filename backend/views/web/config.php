<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Web */

$this->title = '【'.$name.'】网站配置' ;
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
                            <form method="get" id="form_info_str" class="form-horizontal">
                                <?php foreach($data as $k=>$v){ ?>
                                    <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label"><?php echo $k; ?></label>
                                    <div class="col-sm-10">
                                        <input type="text"  <?php if($k=='id' || $k=='web_id'){ echo 'disabled'; } ?> id="<?php echo $k; ?>" value="<?php if(isset($v)) echo $v; ?>" class="form-control">
                                        <span class="help-block m-b-none"></span>
                                    </div>
                                </div>

                                <?php } ?>

                                <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label"></label>
                                    <div class="col-sm-10">

                                        <a class="btn btn-success btn_save" href="javascript:void(0);">提交</a>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                            </form>


                        </div></div></div></div></div></div></div>

<script type="text/javascript">

//    var ue = UE.getEditor('editor');
    $(".btn_save").click(function(){
        var par={};
        <?php foreach($data as $k1=>$v1){ ?>
        par.<?php echo $k1; ?>=$("#<?php echo $k1; ?>").val();
        <?php } ?>
//console.log(par);return false;
        $.post("index.php?r=web/save-config",par,function(data){
            if(data.msg=='1'){
                alert('操作成功！');
                location.reload();
                return false;
            }else{
                alert('操作失败！');
                return false;
            }
        },'json');
    });


    function setContent() {
//        UE.getEditor('editor').setContent('<?php // if(!empty($data['footer'])) echo $data['footer']; ?>//');
    }
    window.onload = function(){
//        alert(1);
//        setContent();
    };
    function test(){
//        setContent();
    }
//    var t1=setTimeout("test()",1000);

</script>