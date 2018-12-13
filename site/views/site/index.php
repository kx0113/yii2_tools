
<body style="background: #fff;">
<link rel="stylesheet" href="static/select2-develop/dist/css/select2.min.css"/>
<link rel="stylesheet" href="static/jquery-jsonview/dist/jquery.jsonview.css"/>
<script type="text/javascript" src="static/jquery/jquery.min.js"></script>
<script type="text/javascript" src="static/jquery-jsonview/dist/jquery.jsonview.js"></script>
<script type="text/javascript" src="static/select2-develop/dist/js/select2.full.min.js"></script>
<div class="container">
    <h1 style="text-align: center;margin:50px;">
        Last Postman
    </h1>
    <div class="col-xs-12" style="background: #eee;padding:30px 20px;border-radius: 5px;">


        <div class="form-group"><a class="btn btn-default check_api" onclick="check_api();">Submit</a></div>
        <div class="form-group">
            <label for="input_url">md5</label>
            <input  style="" type="text" class="form-control"
                   value="" id="text_md5"
                   name="text_md5" placeholder="">
            <br>
            <a class="btn btn-default check_api" onclick="text_md5();">md5</a>
        </div>
        <div class="form-group">
            <label for="input_url">input_url&nbsp;&nbsp【first】</label>
            <input type="text" class="form-control"
                   value="<?php if(isset($data['input_url'])){echo $data['input_url'];}?>" id="input_url"
                   name="input_url" placeholder="">
        </div>

        <div class="form-group">
            <label for="url">auto_url</label>
            <select style="padding:10px 0;" class="js-example-basic-single2  js-states form-control" name="url" id="url">
                <?php if(isset($data['url'])){ foreach($data['url'] as $k=>$v){ ?>
                <option value="<?php echo $v['info']?>"><?php echo $v['name'].'-'.$v['info']?></option>
                <?php } }?>
            </select>
        </div>

        <div class="form-group">
            <label for="action2">action</label>
            <select style="padding:10px 0;" class="js-example-basic-single2  js-states form-control"  name="action" id="action">
            <?php if(isset($data['action'])){ foreach($data['action'] as $k=>$v){ ?>
                <option  data-desc1='<?php echo $v['desc1']?>'
                data-desc2='<?php echo $v['desc2']?>'
                value="<?php echo $v['info']?>"><?php echo $v['name'].'-'.$v['info']?></option>
            <?php } }?>
        </select>
        </div>

        <div class="form-group"  style="margin-bottom: 0;">
            <label for="app_id">secret_key</label>
            <select style="padding:10px 0;" data-status="1"
                    class="js-example-basic-single2  js-states form-control"
                    name="secret_key" id="secret_key">
                <?php if(isset($data['secret_key'])){ foreach($data['secret_key'] as $k=>$v){ ?>
                <option value="<?php echo $v['info']?>"><?php echo $v['name'].'-'.$v['info']?></option>
                <?php } }?>
            </select>
        </div>

        <div class="form-group" >
            <div class=" col-xs-12" style="padding: 0;">
                <div class="checkbox" style="padding: 0;">
                    <label style="padding: 0;">
                        <input type="radio" value="1" onclick="secret_key_switch(1)" checked name="secret_key_switch"> Enabled
                    </label>
                    <label>
                        <input type="radio" onclick="secret_key_switch(2)" value="2" name="secret_key_switch"> Disabled
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <input type="text" class="form-control"
                   value="" id="secret_key_text"
                   name="secret_key_text" placeholder="custom secret_key">
        </div>
        <div class="form-group" style="margin-bottom: 0;">
            <label for="app_id">app_id</label>
            <select style="padding:10px 0;" class="js-example-basic-single2  js-states form-control"  name="app_id" id="app_id">
                <?php if(isset($data['app_id'])){ foreach($data['app_id'] as $k=>$v){ ?>
                <option value="<?php echo $v['info']?>"><?php echo $v['name'].'-'.$v['info']?></option>
                <?php } }?>
            </select>
        </div>

        <div class="form-group" >
            <div class=" col-xs-12" style="padding: 0;">
                <div class="checkbox" style="padding: 0;">
                    <label style="padding: 0;">
                        <input type="radio" value="1" checked name="post_app_id"> Enabled
                    </label>
                    <label>
                        <input type="radio" value="2" name="post_app_id"> Disabled
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group" style="margin-bottom: 0;">
            <label for="timestamp">timestamp</label>
            <input type="text" class="form-control"
                   value="<?php if(isset($data['timestamp'])){echo $data['timestamp'];}?>" id="timestamp"
                   name="timestamp" placeholder="">
        </div>
        <div class="form-group">
            <div class=" col-xs-12" style="padding: 0;">
                <div class="checkbox" style="padding: 0;">
                    <label style="padding: 0;">
                        <input type="radio" value="1" checked name="post_timestamp"> Enabled
                    </label>
                    <label>
                        <input type="radio" value="2" name="post_timestamp"> Disabled
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group" style="margin-bottom: 0;">
            <label for="rand">rand</label>
            <input type="text" class="form-control"
                   value="<?php if(isset($data['rand'])){echo $data['rand'];}?>" id="rand"
                   name="rand" placeholder="">
        </div>
        <div class="form-group">
            <div class=" col-xs-12" style="padding: 0;">
                <div class="checkbox" style="padding: 0;">
                    <label style="padding: 0;">
                        <input type="radio" value="1" checked name="post_rand"> Enabled
                    </label>
                    <label>
                        <input type="radio" value="2" name="post_rand"> Disabled
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="post_sign">post_sign</label>
            <div class="checkbox" style="padding: 0;">
                <label style="padding: 0;">
                    <input type="radio" value="1" checked name="post_sign"> body_sign
                </label>
                <label style="">
                    <input type="radio" value="2" name="post_sign"> header_body_sign
                </label>
                <label>
                    <input type="radio" value="3" name="post_sign"> Disabled
                </label>
            </div>
            <!--<select class="form-control" name="post_sign" id="post_sign">-->
                <!--<option value="1">是</option>-->
                <!--<option value="2">否</option>-->
            <!--</select>-->
        </div>
        <div class="form-group">
            <label for="header_params">header_params</label>
            <textarea class="form-control" id="header_params"
                      name="header_params" rows="8"></textarea>
        </div>
        <div class="form-group">
            <label for="body_params">body_params</label>
            <textarea class="form-control"
                      value='' id="body_params"
                      name="body_params" rows="16"></textarea>
        </div>
        <div class="form-group">
            <label for="sign">return</label>
            <div style="background: #fff;border: 1px solid #ccc;padding:16px;border-radius: 5px;" id="json"></div>
        </div>
        <br>
        <a class="btn btn-default check_api" onclick="check_api();">Submit</a>
        <div style="clear: both"></div>

    </div>

</div>
<br>
<br>
<br>
<br>
<script type="text/javascript">
    $("#secret_key_text").hide();
  $("#action").change(function(){
//      var a = $("select option:selected").attr("name");
      var desc1=$("#action option:selected").attr('data-desc1');
      $("#header_params").html(desc1);
      var desc2=$("#action option:selected").attr('data-desc2');
      $("#body_params").html(desc2);
      console.log(desc1);
  });
  function secret_key_switch(params) {
      $("#secret_key").attr('data-status',params);
      if(params==1){
          $("#secret_key_text").hide();
      }else{
          $("#secret_key_text").show();
      }

  }
    $(".js-example-basic-single2").select2({
        placeholder: "Select a State",
        allowClear: true,
        closeOnSelect:true
    });
    $(".js-example-basic-single20").select2({
        placeholder: "Select a State",
        allowClear: true,
        maximumSelectionLength :1,
        closeOnSelect:true
    });
    $(".js-example-basic-single3").select2({
        placeholder: "Select a State",
        allowClear: true,
        closeOnSelect:true
    });
    $(".js-example-basic-single4").select2({
        placeholder: "Select a State",
        allowClear: true,
        closeOnSelect:true
    });
//    get_action();
    function text_md5() {
        $.post("index.php?r=site/text-md5", {"str":$("#text_md5").val()}, function (e) {
            $("#text_md5").val(e.post_return);
        }, 'json');
    }
    function check_api() {
        $("#json").html('');
        var params = {};
        var post_timestamp = $('input[name="post_timestamp"]:checked ').val();
        var post_rand = $('input[name="post_rand"]:checked ').val();
        var post_app_id = $('input[name="post_app_id"]:checked ').val();
        var post_sign = $('input[name="post_sign"]:checked ').val();
        var secret_key_status = $("#secret_key").attr('data-status');
        params.auto_url = $("#url").val() + $("#action").val();
        params.input_url = $("#input_url").val();
        params.secret_key = $("#secret_key").val();
        if(post_timestamp=="1"){
            params.timestamp = $("#timestamp").val();
        }
        if(post_rand=="1"){
            params.rand = $("#rand").val();
        }
        if(post_app_id=="1"){
            params.app_id = $("#app_id").val();
        }
        if(secret_key_status=='1'){
            params.secret_key = $("#secret_key").val();
        }else{
            params.secret_key = $("#secret_key_text").val();
        }
        params.post_sign =post_sign;
        params.body_params = $("#body_params").val();
        params.header_params = $("#header_params").val();
        console.log(params);
//        return false;
        $.post("index.php?r=site/checkapi", params, function (e) {
            $("#json").JSONView(e);
        }, 'json');
    }



</script>