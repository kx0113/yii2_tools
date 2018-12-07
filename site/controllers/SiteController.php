<?php
namespace site\controllers;


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
use common\models\ProductType;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use common\models\Company;
use common\models\FrontLog;

/**
 * Site controller
 */
class SiteController extends Controller
{

    public function init(){
        parent::init();
    }
    public function checkField($data = '', $default = ''){

    }
    public function checkField2()
    {
        return $this->fetch('test');

    }
    public function ReturnJsonData($data){
        $arr=['post_return'=>$data];
        echo json_encode($arr);
        exit;
    }


    public function api_sign()
    {
//        Yii::$app->params['web1']['news_index_limit'];
        $data['input_url'] = '';
        $data['url'] = config('tools.curl_host');
        $data['app_id'] = config('tools.curl_appid');
        $data['secret_key'] = config('tools.curl_secret');
        $data['action'] = config('tools.curl_action');
        $data['timestamp'] = time();
        $data['rand'] = rand(1111, 9999);
//        return $this->fetch('api_sign', ['data' => $data]);
    }

    public function actionError(){

    }
    public function actionCheckapi()
    {
        $url = '';
        $headers_curl = [];
        $headers_array = [];
        $params = [];
        $body_array = [];
        $post = $_POST;
        #获取url  input_url优先
        if (isset($post['input_url']) && !empty(trim($post['input_url']))) {
            $url = trim($post['input_url']);
        } else {
            if (isset($post['auto_url']) && !empty(trim($post['auto_url']))) {
                $url = trim($post['auto_url']);
            } else {
                $this->ReturnJsonData(['url错误']);
            }
        }

        if (!isset($post['secret_key']) && empty(trim($post['secret_key']))) {
            $this->ReturnJsonData(['secret_key错误']);
        }
        $is_sign = trim($post['post_sign']);
        $secret_key = trim($post['secret_key']);
        unset($post['post_sign']);
        unset($post['input_url']);
        unset($post['auto_url']);
        unset($post['secret_key']);
        if (isset($post['rand'])) {
            $params['rand'] = !empty($post['rand']) ? trim($post['rand']) : rand(1111, 9999);
        }
        if (isset($post['app_id'])) {
            $params['app_id'] = !empty($post['app_id']) ? trim($post['app_id']) : '';
        }
        if (isset($post['timestamp'])) {
            $params['timestamp'] = !empty($post['timestamp']) ? trim($post['timestamp']) : time();
        }
        #解析header json
        $header_res = $this->headerParamsHandle($post);
//        var_dump($header_res);exit;
        if (false === $header_res) {
            $this->ReturnJsonData(['header_params json 格式错误']);
        } else {
            if(!empty($header_res)){
                if (isset($header_res['header_params']) && is_array($header_res['header_params'])) {
                    $headers_array = $header_res['header_params'];
                }
                if (isset($header_res['header_curl']) && !empty($header_res['header_curl'])) {
                    $headers_curl = $header_res['header_curl'];
                }
            }
        }
//        $this->ReturnJsonData($header_res);exit;
        #解析body json
        $body_res = $this->BodyParamsHandle($post);
        if (false === $body_res) {
            $this->ReturnJsonData(['body_params json 格式错误']);
        } else {
            if(!empty($header_res)){
                if (isset($body_res['body_params']) && is_array($body_res['body_params'])) {
                    $body_array = $body_res['body_params'];
                }
            }
        }
//        $params=$this->postParamsHandle($post,$body_array);
        $params = array_merge($body_array, $post);
        unset($params['body_params']);
        unset($params['header_params']);
        $body_header_params = array_merge($params, $headers_array);
//        echo json_encode([$body_res,$header_res]);exit;
//        $post=array_merge($headerParamsHandle,$BodyParamsHandle,$post);
//        $this->ReturnJsonData($body_header_params);exit;

        $body_sign = $this->sign($params, $secret_key);
        $body_header_sign=$this->sign($body_header_params, $secret_key);
        if ($is_sign == 1) {
            $params['sign'] = $body_sign['sign'];
        }elseif ($is_sign == 2){
            $params['sign'] = $body_header_sign['sign'];
        }
        $return_curl = $this->api_curl($url, $params, $headers_curl);
        $arr = [
            'request_url' => $url,
//            'post_array' => $params,
            'headers_array' => $headers_array,
//            'header_curl' => $headers_curl,
            'body_array' => $body_array,
//            'header_sign' => $this->sign($headers_array, $secret_key),
//            'body_sign' => $this->sign($body_array, $secret_key),
//            'header_body_sign' => $this->sign($body_header_params, $secret_key),
            'curl_params' => $params,
            'curl_return' => $return_curl,
        ];
        $this->ReturnJsonData($arr);
    }
    public function api_curl($url, $data = [], $header=[],$timeoutMs = 3000)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, $timeoutMs);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        if (!empty($data)) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        $rand=rand(1111,9999);
        $rs = curl_exec($ch);


        if ($rs === false) {
            $rs = [
                'code' => 0,
                'data' => null,
                'msg'  =>  'curl返回：(' . curl_error($ch) . ')'
            ];
            curl_close($ch);
            return $rs;
        }

        curl_close($ch);

//        return $rs;
        return json_decode($rs, true);
    }
    public function postParamsHandle($post = '', $body = '')
    {

    }

    /**
     * @desc 处理 header 参数
     */
    public function headerParamsHandle($post)
    {
        $arr = [];
        $headers = [];
        if (isset($post['header_params']) && !empty(trim($post['header_params']))) {
            #判断是否json
            if ($this->is_json($post['header_params'])) {
                $header_params = json_decode(trim($post['header_params']), true);
                #判断json解析后是否数组
                if (is_array($header_params)) {
                    foreach ($header_params as $k => $v) {
                        $headers[] = $k . ':' . $v;
                    }
                    unset($post['header_params']);
                    $arr['header_params'] = $header_params;
                    $arr['header_curl'] = $headers;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return '';
        }
        return $arr;
    }
    public function is_json($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
        /**
     * @desc 处理 body 参数
     */
    public function BodyParamsHandle($data)
    {
        $arr = [];
        if (isset($data['body_params']) && !empty(trim($data['body_params']))) {
            if ($this->is_json($data['body_params'])) {
                $body_params = json_decode(trim($data['body_params']), true);
                if (is_array($body_params)) {
                    if (isset($body_params['list']) && is_array($body_params['list']) && !empty($body_params['list'])) {
                        $arr['list'] = json_encode($body_params['list']);
                    }
                    unset($data['body_params']);
                    $arr['body_params'] = $body_params;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return '';
        }
        return $arr;
    }

    /**
     * @desc 生成sign
     */
    public function sign($params = [], $secret_key = '')
    {
        if (isset($params['sign'])) {
            unset($params['sign']);
        }
        ksort($params);
        $pair = [];
        foreach ($params as $k => $v) {
            $pair[] = $k . '=' . $v;
        }
        $str = implode('&', $pair); // 拼接字符串
        $str = $str . $secret_key; // 把secret_key补充到最后
        $arr = [
//            'params' => $params,
            'sign' => md5($str),
//            'calc_string' => $str
        ];
        return $arr;
    }
    /**
     * 首页
     * @return mixed
     */
    public function actionIndex()
    {
        $data['input_url'] = '';
        $data['url'] =  Yii::$app->params['curl_host'];
        $data['app_id'] =  Yii::$app->params['curl_appid'];
        $data['secret_key'] =  Yii::$app->params['curl_secret'];
        $data['action'] =  Yii::$app->params['curl_action'];
        $data['timestamp'] = time();
        $data['rand'] = rand(1111, 9999);
        return $this->render('index',['data'=>$data]);
    }
    public function actionGetaction(){
        $arr=[];
        $children=[];
        $data=Yii::$app->params['curl_action'];
        foreach ($data as $k=>$v){
            $children[$k]['text']=$v['text'];
            foreach ($v['children'] as $k2=>$v2){
                $children[$k]['children'][]=['id'=>$v2['info'],'text'=>$v2['name'].'-'.$v2['info']];
            }
        }
        echo json_encode($children);exit;
    }
}