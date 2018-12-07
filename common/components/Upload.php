<?php
namespace common\components;

use yii;
use yii\base\Object;
use yii\web\UploadedFile;
use \common\helps\file;//引入文件操作类

class Upload{

    public $upload = '';

    public function __construct(){
        $this->upload = Yii::getAlias('@data/upload');
    }
    /**
     * 复制文件
     *
     * @param string $fileUrl
     * @param string $aimUrl
     * @param boolean $overWrite
     *        	该参数控制是否覆盖原文件
     * @return boolean
     */
    public function copyFile($fileUrl, $aimUrl, $overWrite = true) {
        if (! file_exists ( $fileUrl )) {
            return false;
        }
        if (file_exists ( $aimUrl ) && $overWrite == false) {
            return false;
        } elseif (file_exists ( $aimUrl ) && $overWrite == true) {
            $this->unlinkFile ( $aimUrl );
        }
        $aimDir = dirname ( $aimUrl );
        $this->createDir ( $aimDir );
        return @copy ( $fileUrl, $aimUrl );
    }
    /**
     * 建立文件夹
     *
     * @param string $aimUrl
     * @return viod
     */
    public function createDir($aimUrl, $mode = 0777) {
        $aimUrl = str_replace ( '', '/', $aimUrl );
        $aimDir = '';
        $arr = explode ( '/', $aimUrl );
        foreach ( $arr as $str ) {
            $aimDir .= $str . '/';
            if (! file_exists ( $aimDir )) {
                @mkdir ( $aimDir, $mode );
            }
        }
        return true;
    }
    /**
     * 删除文件
     *
     * @param string $aimUrl
     * @return boolean
     */
    public function unlinkFile($id) {
        if (file_exists ( $id )) {
            unlink ( $id );
            return true;
        } else {
            return false;
        }
    }
    /**
     * @desc 返回一个日期时间字符串
     * @return string
     */
    public function actionGetFormatString(){
        return date('Ymd_His') . '_' . file::getInstance()->randName() ;
    }
    public function imgread($img,$par=1){
        $banner=explode(',',$img);
        if(count($banner) > '1'){
            $str='';
            foreach ($banner as $indexk => $itemk) {
                $str.= Yii::$app->params['upload_path'].$itemk.',';
            }
            return substr($str,0,strlen($str)-1);
        }else{
            return Yii::$app->params['upload_path'].$img;
        }

        return false;
    }
    /**
     * xushenkai modify
     *@param $fileName 上传控件名
     * return array 返回源文件名称以及现文件名称（数据库存）
     */
    public function UploadImg($fileName)
    {
        if ($fileName) {
            //上传文件对象
            $fileObj = UploadedFile::getInstanceByName($fileName);
            //重命名后的文件名
            $re_name = $this->actionGetFormatString() . '.' . $fileObj->extension;
            //文件完整路径
            $attPath = file::getInstance()->createDir($this->upload) . $re_name;
            $file_path= '/data/upload/'.file::getInstance()->time_path_dir().$re_name;

            //复制文件使用新的文件名
            $res= $fileObj->saveAs($attPath);
            if(!empty($res)){
                return $file_path;
            }
        }
        return false;
    }
}

?>