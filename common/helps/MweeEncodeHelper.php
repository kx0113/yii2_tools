<?php

namespace common\helps;

use yii\base\Exception;

/**
 * 美味数据加密、解密公用接口
 * Class MweeEncodeHelper
 * @package common\helps
 */
class MweeEncodeHelper
{
    public $errmsg = '';
    private static $_instance;

    /**
     * 单例模式
     * @return MweeEncodeHelper
     */
    public static function getInstance(){
        if(!(self::$_instance instanceof self)){
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    /*********************************************************************
     * url处理base64
     *********************************************************************/
    protected  function reflowURLSafeBase64($str){
        $str=str_replace("/","_",$str);
        $str=str_replace("+","-",$str);
        return $str;
    }

    /*********************************************************************
     * 普通处理base64
     *********************************************************************/
    protected  function reflowNormalBase64($str){
        $str=str_replace("_","/",$str);
        $str=str_replace("-","+",$str);
        return $str;
    }

    /*********************************************************************
     * pkcs
     *********************************************************************/
    protected  function pkcs5_pad($text, $blocksize){
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }

    /*********************************************************************
     * 加密
     *********************************************************************/
    public  function encrypt($input, $key){
        $size  = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
        $input = $this->pkcs5_pad($input, $size);
        $td    = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_ECB, '');
        $iv    = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        mcrypt_generic_init($td, base64_decode($key), $iv);
        $data = mcrypt_generic($td, $input);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        $data = base64_encode($data);
        $data = $this->reflowURLSafeBase64($data);
        return $data;
    }

    /*********************************************************************
     * 解密
     *********************************************************************/
    public  function decrypt($sStr, $sKey){
        $sStr = $this->reflowNormalBase64($sStr);
        $sKey = $this->reflowNormalBase64($sKey);
        $decrypted = mcrypt_decrypt(MCRYPT_RIJNDAEL_128,
            base64_decode($sKey), base64_decode($sStr),
            MCRYPT_MODE_ECB);
        $dec_s     = strlen($decrypted);
        $padding   = ord($decrypted[$dec_s - 1]);
        $decrypted = substr($decrypted, 0, -$padding);
        return $decrypted;
    }

    /*********************************************************************
     * 接口调用
     *********************************************************************/
    public function callApi($api, $params, &$code, &$src){

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_URL, $api);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        $src    = $file_contents = curl_exec($ch);
        $code   = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if($file_contents === false){
            $ip     = $_SERVER['SERVER_ADDR'];
            $this->errmsg = $ip . ':' . curl_error($ch) . ':' . $return_code;
            $ret    = false;
        }else{
            $ret = json_decode($file_contents, true);
            if(!$ret){
                $ip     = $_SERVER['SERVER_ADDR'];
                $this->errmsg = $ip . ':' . $return_code . ':res:' . $file_contents;
            }
        }

        curl_close($ch);

        return $ret;
    }

    private function __construct(){

    }

    public function __clone(){
        trigger_error('Clone is not allow!',E_USER_ERROR);
    }

}