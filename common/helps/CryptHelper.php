<?php

namespace common\helps;

class CryptHelper extends \yii\helpers\StringHelper
{
    /*
    * 函数名称:encrypt
    * 函数作用:加密解密字符串
    * 使用方法:
    * 加密     :encrypt('str','E','nowamagic');
    * 解密     :encrypt('被加密过的字符串','D','nowamagic');
    * 参数说明:
    * $string   :需要加密解密的字符串
    * $operation:判断是加密还是解密:E:加密   D:解密
    * $key      :加密的钥匙(密匙);
    */
    static public function encrypt($string,$operation,$key='nowamagic')
    {
        $key=md5($key);
        $key_length=strlen($key);
        $string=$operation=='D'?base64_decode($string):substr(md5($string.$key),0,8).$string;
        $string_length=strlen($string);
        $rndkey=$box=array();
        $result='';
        for($i=0;$i<=255;$i++)
        {
            $rndkey[$i]=ord($key[$i%$key_length]);
            $box[$i]=$i;
        }
        for($j=$i=0;$i<256;$i++)
        {
            $j=($j+$box[$i]+$rndkey[$i])%256;
            $tmp=$box[$i];
            $box[$i]=$box[$j];
            $box[$j]=$tmp;
        }
        for($a=$j=$i=0;$i<$string_length;$i++)
        {
            $a=($a+1)%256;
            $j=($j+$box[$a])%256;
            $tmp=$box[$a];
            $box[$a]=$box[$j];
            $box[$j]=$tmp;
            $result.=chr(ord($string[$i])^($box[($box[$a]+$box[$j])%256]));
        }
        if($operation=='D')
        {
            if(substr($result,0,8)==substr(md5(substr($result,8).$key),0,8))
            {
                return substr($result,8);
            }
            else
            {
                return '';
            }
        }
        else
        {
            return str_replace('=','',base64_encode($result));
        }
    }

    /**
     * DES加密
     * @param $text
     * @param $key
     * @return string
     */
    public static function encode($text,$key){
        $text = self::_pkcs5Pad($text, mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB));
        $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_ECB, '');
        $iv = @mcrypt_create_iv (mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        mcrypt_generic_init($td, $key, $iv);
        $cyper_text = mcrypt_generic($td, $text);
        $result = base64_encode($cyper_text);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        return $result;
    }

    private static function _pkcs5Pad($text, $blocksize) {
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }

    /**
     * DES解密
     * @param $str
     * @param $key
     * @return bool|string
     */
    public static function decrypt($str,$key){
        $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_ECB, '');
        $iv = @mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        mcrypt_generic_init($td, $key, $iv);
        $decrypted_text = mdecrypt_generic($td, base64_decode($str));
        $result = $decrypted_text;
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        return self::_pkcs5Unpad($result);
    }

    private static function _pkcs5Unpad($text) {
        $pad = ord($text {strlen($text) - 1});
        if ($pad > strlen($text))
            return false;
        if (strspn($text, chr($pad), strlen($text) - $pad) != $pad)
            return false;
        return substr($text, 0, - 1 * $pad);
    }

    /**
     * base64 加密
     * @param $str
     * @return mixed
     */
    function base_encode($str) {
        $src  = array("/","+","=");
        $dist = array("_a","_b","_c");
        $old  = base64_encode($str);
        $new  = str_replace($src,$dist,$old);
        return $new;
    }

    /**
     * base64 解密
     * @param $str
     * @return string
     */
    function base_decode($str) {
        $src = array("_a","_b","_c");
        $dist  = array("/","+","=");
        $old  = str_replace($src,$dist,$str);
        $new = base64_decode($old);
        return $new;
    }

    /**
     * 加密
     * @param $params
     */
    public static function getSign($params) {
        $sign = "**xmebank**";
        unset($params['sign']);
        ksort($params);
        $signStr = http_build_query($params) . $sign;
        return md5($signStr);
    }

    /**
     * 解密
     * @param $paramsOne
     * @param $paramsTwo
     */
    public static function validateSign($params, $sign)
    {
        return self::getSign($params) == $sign;
    }
}