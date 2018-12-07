<?php

namespace common\helps;

class StringHelper extends \yii\helpers\StringHelper
{
    /**
     * 模糊手机号
     * 比如：13917883434 变成 139****3434
     */
    public static function blurPhone($phone)
    {
        return substr($phone, 0, 3) . '****' . substr($phone, 7);
    }

    /**
     * 验证手机号是否合法
     * @param $phone
     * @return int
     */
    public static function idenPhone($phone) {
        return preg_match("/^1[34578]\d{9}$/", $phone);
    }

    /**
     * 格式化手机号
     * 比如：13917883434 变成 139 1788 3434
     */
    public static function formatPhone($phone)
    {
        return substr($phone, 0, 3) . ' ' . substr($phone, 3 , 4) . ' ' . substr($phone, 7);
    }

    /**
     * 模糊真名
     * 比如：林佳神 变成 *佳神
     */
    public static function blurName($name)
    {
        return '*' . mb_substr($name, 1, 8, 'UTF-8');
    }

    /**
     * 模糊银行卡
     * 比如：6224 8851 1234 4568 变成 6224 **** 4568
     */
    public static function blurCardNo($card_no)
    {
        $start_pos = strlen($card_no) - 4;
        return substr($card_no, 0, 4) . ' **** ' . substr($card_no, $start_pos);
    }

    /**
     * 模糊身份证
     * 比如：302121 21212112 112x 变成 3021 ********** 112x
     */
    public static function blurIdCard($card_no)
    {
        $start_pos = strlen($card_no) - 8;
        return substr($card_no, 0, 4) . preg_replace("/\d/", '*', substr($card_no, 5, $start_pos)) . substr($card_no, -4);
    }

    /**
     * 安全的将“元”转化成“分”
     * 比如：10.01 变成 1001
     */
    public static function safeConvertCentToInt($num)
    {
        return intval(bcmul(floatval($num) , 100));
    }

    /**
     * 安全的将“分”转化成“元”
     * 比如：1001 变成 10.01
     */
    public static function safeConvertIntToCent($num){
        return sprintf('%.2f',$num / 100);
    }

    // 删除银行卡中的空格
    public static function trimBankCard($bank_card)
    {
        $bank_card = str_replace(" ",'',$bank_card);
        if(preg_match('/^[0-9]{10,24}$/',$bank_card))
        {
            return $bank_card;
        }
        return false;
    }

    //验证手机号
    public static function verifyNumber($str) {
        $str = str_replace(" ", '', $str);
        if (preg_match('/^[0-9]*$/', $str)) {
            return $str;
        }
        return false;
    }

    //验证中文姓名
    public static function isChineseName($name){
        if (preg_match("/^[\x{4e00}-\x{9fa5}]+$/u", $name)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 验证身份证号码是否合法(兼容15位和17位)
     * @param $idcard
     * @return bool
     */
    public static function isIdCard($idcard) {
        $idCardLength = strlen($idcard);
        //长度验证
        if (!preg_match('/^\d{17}(\d|x)$/i', $idcard) and !preg_match('/^\d{15}$/i', $idcard)) {
            return false;
        }
        $factor = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
        $verify_number_list = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
        // 15位身份证验证生日，转换为18位
        if ($idCardLength == 15) {
            //若身份证顺序码是996 997 998 999，说明是为百岁老人准备的特殊码
            if (array_search(substr($idcard, 12, 3), array('996', '997', '998', '999')) !== false) {
                $idcard = substr($idcard, 0, 6) . '18'. substr($idcard, 6, 9);
            } else {
                $idcard = substr($idcard, 0, 6) . '19'. substr($idcard, 6, 9);
            }
            $checksum = 0;
            for ($i = 0; $i < strlen($idcard); $i++) {
                $checksum += substr($idcard, $i, 1) * $factor[$i];
            }
            $mod = $checksum % 11;
            $verify_number = $verify_number_list[$mod];
            $idcard = $idcard .$verify_number;
        }
        if (strlen($idcard) != 18){
            return false;
        }
        $idcard_base = substr($idcard, 0, 17);
        if (strlen($idcard_base) != 17) {
            return false;
        }
        $checksum = 0;
        for ($i = 0; $i < strlen($idcard_base); $i++) {
            $checksum += substr($idcard_base, $i, 1) * $factor[$i];
        }
        $mod = $checksum % 11;
        $verify_number = $verify_number_list[$mod];
        if ($verify_number != strtoupper(substr($idcard, 17, 1))) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * 生成唯一ID
     * @return string
     */
    public static function generateUniqid()
    {
        $prefix = rand(0, 9);
        return uniqid($prefix);
    }


    public static function trimString($str)
    {
        $search = array(" ","　","\n","\r","\t");
        $replace = array("","","","","");
        return str_replace($search, $replace, $str);
    }

    public static function pykey( $py_key)
    {   $py = self::pys($py_key);
        $pinyin = 65536 + $py;
        if ( 45217 <= $pinyin && $pinyin <= 45252 )
        {
            $zimu = "A";
            return $zimu;
        }
        if ( 45253 <= $pinyin && $pinyin <= 45760 )
        {
            $zimu = "B";
            return $zimu;
        }
        if ( 45761 <= $pinyin && $pinyin <= 46317 )
        {
            $zimu = "C";
            return $zimu;
        }
        if ( 46318 <= $pinyin && $pinyin <= 46825 )
        {
            $zimu = "D";
            return $zimu;
        }
        if ( 46826 <= $pinyin && $pinyin <= 47009 )
        {
            $zimu = "E";
            return $zimu;
        }
        if ( 47010 <= $pinyin && $pinyin <= 47296 )
        {
            $zimu = "F";
            return $zimu;
        }
        if ( 47297 <= $pinyin && $pinyin <= 47613 )
        {
            $zimu = "G";
            return $zimu;
        }
        if ( 47614 <= $pinyin && $pinyin <= 48118 )
        {
            $zimu = "H";
            return $zimu;
        }
        if ( 48119 <= $pinyin && $pinyin <= 49061 )
        {
            $zimu = "J";
            return $zimu;
        }
        if ( 49062 <= $pinyin && $pinyin <= 49323 )
        {
            $zimu = "K";
            return $zimu;
        }
        if ( 49324 <= $pinyin && $pinyin <= 49895 )
        {
            $zimu = "L";
            return $zimu;
        }
        if ( 49896 <= $pinyin && $pinyin <= 50370 )
        {
            $zimu = "M";
            return $zimu;
        }
        if ( 50371 <= $pinyin && $pinyin <= 50613 )
        {
            $zimu = "N";
            return $zimu;
        }
        if ( 50614 <= $pinyin && $pinyin <= 50621 )
        {
            $zimu = "O";
            return $zimu;
        }
        if ( 50622 <= $pinyin && $pinyin <= 50905 )
        {
            $zimu = "P";
            return $zimu;
        }
        if ( 50906 <= $pinyin && $pinyin <= 51386 )
        {
            $zimu = "Q";
            return $zimu;
        }
        if ( 51387 <= $pinyin && $pinyin <= 51445 )
        {
            $zimu = "R";
            return $zimu;
        }
        if ( 51446 <= $pinyin && $pinyin <= 52217 )
        {
            $zimu = "S";
            return $zimu;
        }
        if ( 52218 <= $pinyin && $pinyin <= 52697 )
        {
            $zimu = "T";
            return $zimu;
        }
        if ( 52698 <= $pinyin && $pinyin <= 52979 )
        {
            $zimu = "W";
            return $zimu;
        }
        if ( 52980 <= $pinyin && $pinyin <= 53640 )
        {
            $zimu = "X";
            return $zimu;
        }
        if ( 53689 <= $pinyin && $pinyin <= 54480 )
        {
            $zimu = "Y";
            return $zimu;
        }
        if ( 54481 <= $pinyin && $pinyin <= 62289 )
        {
            $zimu = "Z";
            return $zimu;
        }
        $zimu = $py_key;
        return $zimu;
    }

    public static function pys( $pysa )
    {
        $pyi = "";
        $i= 0;
        for ( ; $i < strlen( $pysa ); $i++)
        {
            $_obfuscate_8w= ord( substr( $pysa,$i,1) );
            if ( 160 < $_obfuscate_8w)
            {
                $_obfuscate_Bw = ord( substr( $pysa, $i++, 1 ) );
                $_obfuscate_8w = $_obfuscate_8w * 256 + $_obfuscate_Bw - 65536;
            }
            $pyi.= $_obfuscate_8w;
        }
        return $pyi;
    }
}