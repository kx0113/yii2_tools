<?php
namespace common\components;

use common\models\CompanyType;
use mdm\admin\models\searchs\Menu;
use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\FrontMenu;
use common\models\WebCommon;
use common\models\Product;
use common\models\News;
use common\models\NewType;
use common\models\ProductType;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use common\models\Company;
use common\models\Web;
use common\models\FrontLog;
use common\models\Logs;
use common\models\Message;

class Common {


    /**
     * 初始化函数
     * CommonSel constructor.
     */
    public function __construct() {

    }

    /**
     * @desc 发送邮件
     * @return array
     */
    public function SendMailer($to,$sub,$body){
        $arr=[];
        $mail= Yii::$app->mailer->compose();
        $mail->setSubject($sub); //邮件主题
        $mail->setHtmlBody($body); //发送的消息内容
        if(is_array($to)){
            foreach($to as $v){
                $mail->setTo($v); //要发送给那个人的邮箱
                $arr[]=$mail->send();
            }
        }else{
            $mail->setTo($to); //要发送给那个人的邮箱
            $arr[]=$mail->send();
        }
        return $arr;
    }

    /**
     * @desc 预览访问日志生成html
     */
    public function FrontLogHtml(){
        $html='<div>';
        $r=$this->selFrontLog();
        $html.='<div style=""><br>&nbsp;&nbsp;&nbsp;时间：'.date('Y-m-d H:i:s',$r['where'][2]).'至'.date('Y-m-d H:i:s',$r['where'][3]).'</div><br>';
        $html.='<table class="table table-bordered table-hover table-responsive">
        <tr>
        <td>网址</td>
        <td>备注</td>
        <td>时间</td>
        <td>IP</td>
        <td>ip地址[百度]</td>
        <td>ip地址[阿里]</td>
        <td>来源</td>
        </tr>'.$r['html'].'
       </table>';
       echo $this->ReturnHtml($html);exit;
    }
    /**
     * @desc 返回邮件数据tr
     * @return array
     */
    public function selFrontLog(){
        $html='';
        $where=['between', 'time', strtotime(date('Y-m-d 00:00:00')), strtotime(date('Y-m-d 23:59:59')." + 1 day")];
        $res=FrontLog::find()->where($where)->orderBy('id desc')->asArray()->all();
        foreach($res as $k=>$v){
            $html.="<tr>
                    <td style='width:50px;'>".$v['url']."</td>
                    <td>".$v['msg']."</td>
                    <td>".$v['date']."</td>
                    <td>".$v['ip']."</td>
                    <td>".$v['area']."</td>
                    <td>".$v['area2']."</td>
                    <td>".$v['form']."</td>
                </tr>";
        }
        return ['html'=>$html,'where'=>$where];
    }

    /**
     * @desc 组织邮件发送数据
     * @return array
     */
    public function sendMailFrontLog(){
        $data=$this->selFrontLog();
        $html='';
        $html.='
        <style>
        *{padding:0;margin:0;text-align: center;}
        table tr td{border: 1px solid #ccc;}
        </style>
        <div style="padding:30px;">
        <h2>访问日志'.date('Y-m-d').'</h2><br>';
        $html.='<div>时间：'.date('Y-m-d H:i:s',$data['where'][2]).'至'.date('Y-m-d H:i:s',$data['where'][3]).'</div><br>';
        $html.='<table class="">
        <tr>
        <td>网址</td>
        <td>备注</td>
        <td>时间</td>
        <td>IP</td>
        <td>ip地址[百度]</td>
        <td>ip地址[阿里]</td>
         <td>来源</td>
        </tr>
        ';
        $html.=$data['html'];
        $html.='</table></div>';
        return ['html'=>$html,'date'=>$data['where']];
    }
    /**
     * @desc 返回bootstrap html
     * @return array
     */
    public function ReturnHtml($html,$html_head='',$html_foot='',$title=''){
        return '<!DOCTYPE html>
        <html lang="zh-CN">
        <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
        <title>'.$title.'</title>

        <!-- Bootstrap -->
        <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

        <!-- HTML5 shim 和 Respond.js 是为了让 IE8 支持 HTML5 元素和媒体查询（media queries）功能 -->
        <!-- 警告：通过 file:// 协议（就是直接将 html 页面拖拽到浏览器中）访问页面时 Respond.js 不起作用 -->
        <!--[if lt IE 9]>
        <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        </head>
        <body>
        '.$html_head.$html.$html_foot.'

        <!-- jQuery (Bootstrap 的所有 JavaScript 插件都依赖 jQuery，所以必须放在前边) -->
        <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
        <!-- 加载 Bootstrap 的所有 JavaScript 插件。你也可以根据需要只加载单个插件。 -->
        <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        </body>
        </html>';
    }
}