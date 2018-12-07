<?php

namespace common\helps;

use Yii;

class file {
	
	//单例模式
    private static $instance = NULL;
    private static $uploadDir = '';
    
    public static function getInstance($upload_dir = "")
    {
        if(self::$instance === null)
        {
            $classname = __CLASS__;
            self::$instance = new $classname();
            self::$uploadDir = empty($upload_dir) ? Yii::getAlias('@data/upload') : $upload_dir;
        }
        return self::$instance;
    }
    
    /**
     * @desc 通过特定图片名输出图片.eg：'20160818120553_dc37n4.jpg'
     * @param string $file
     * @return boolean|Ambigous <boolean, string>
     */
    public function img($file){
        $fileRelativePath= $this->getRelativePathByAttName($file);
        if (!$fileRelativePath) {
            return false;
        }
    	$filePath = self::$uploadDir . $fileRelativePath;
    	if (!file_exists($filePath)) {
            return false;
        }
        return $this->readImage($filePath, $file);
    }

    /**
     * 获得图片路径
     * @param $file
     * @return string
     */
    public function imgPath($file) {
        return self::$uploadDir . $this->getRelativePathByAttName($file);
    }
    
    /**
     * @desc 读取文件流并输出到浏览器
     * @param string $file 原始文件路径
     * @return boolean|string
     */
    public function readImage($file, $file_name = ''){
    	if (!file_exists($file))
    		return false;
    	switch (self::getExt($file))
    	{
    		case 'jpg':
    			header( "Content-type: image/jpg");
    			break;
    		case 'gif':
    			header( "Content-type: image/gif");
    			break;
    		case 'png':
                header("Content-Type: image/png");
                break;
            case 'pdf':
                header('Content-Type: application/pdf');
                break;
            case 'xls':
            case 'xlxs':
            case 'xlsx':
                header("Content-type:application/vnd.ms-excel");
                header("Content-Disposition:attachement;filename=$file_name");
                break;
            case 'swf':
                header("Content-type:application/x-shockwave-flash");
                break;
    		default:
    			header( "Content-type: image/jpg");
    	}
        ob_clean();
        ob_start();
    	$img = fread(fopen($file,"r"), filesize($file));
    	ob_end_flush();
    	return $img;
    }
    
    /**
     * @desc 文件下载
     * @param string $file 原始文件路径
     * @param string $re_name 自定义下载的文件名,默认下载文件和服务器文件名一样
     * @return bool 文件不存在或文件下载失败  返回false
     */
    public function download($file, $re_name=''){
    	if (!file_exists($file))
    		return false;
    	$filename = basename($file);
    	$re_name = !empty($re_name) ? $re_name : $filename;
    	header("Content-type: application/octet-stream");
    	//处理中文文件名
    	$ua = $_SERVER["HTTP_USER_AGENT"];
        ob_clean();
        if (preg_match("/MSIE/", $ua)) {
    		header('Content-Disposition: attachment; filename="' . $encoded_filename = rawurlencode($re_name) . '"');
    	} else if (preg_match("/Firefox/", $ua)) {
    		header("Content-Disposition: attachment; filename*=\"utf8''" . $re_name . '"');
    	} else {
    		header('Content-Disposition: attachment; filename="' . $re_name . '"');
    	}
    	//header("X-Sendfile: $file");//X-Sendfile头将被Apache处理, 并且把响应的文件直接发送给Client.不消耗PHP本身的性能
    	header("Content-Length: ". filesize($file));
    	return readfile($file);//需要采用MMAP(如果支持), 或者是一个固定的buffer去循环读取文件, 直接输出.效率略低
    }

	public function time_path_dir(){
		return date('Y/m/d', time()).'/';
	}
	/**
	 * @desc 创建    年、月、日、时分秒_随机数  这样的目录
	 * @param $path 根路径  /srv/www/advanced/backend/web/upload
	 * @return string | bool  /srv/www/advanced/backend/web/upload/2016/08/18
	 */
	public function createDir($path){
		$datePath = $path.'/'.$this->time_path_dir();
		if (is_dir($datePath)) {
			return $datePath;
		}else {
			$result = @mkdir($datePath, 0777, true);
			if ($result) {
				//创建目录成功
				return $datePath;
			}else {
				//创建目录失败
				return false;
			}
		}
	}
	
	/**
	 * @desc 通过附件名称拼出附件相对路径,如果真实存在则返回相对路径，不存在则返回false
	 * @param string $attName  '20160818120553_dc37n4.jpg'
	 * @return string | bool   '/2016/08/18/20160818120553_dc37n4.jpg'
	 */
	public function getRelativePathByAttName($attName, $flag = false){
		if (isset($attName)) {
			//相对路径
			$RelativePath = '/' . substr($attName, 0, 4) . '/'. substr($attName, 4, 2) . '/' . substr($attName, 6, 2) . '/';
			//绝对路径
			$AbsolutePath = self::$uploadDir . $RelativePath . $attName;

            if (file_exists($AbsolutePath) || $flag) {
				//返回附件相对data/upload的路径
				return $RelativePath . $attName;
			}
		}
		return false;
	}
	
	//获取文件后缀
	public static function getExt($file) {
		$tmp = explode('.',$file);
		return end($tmp);
	}
	
	//随机生成文件名
	public  function randName() {
		$str = 'QWERTYUIOPASDFGHJKLMNBVCXZabcdefghijkmnpqrstwxyz1234567890';
		return substr(str_shuffle($str),0,10);
	}
	
	// 创建目录
	function forcemkdir($path) {
		if (! file_exists ( $path )) {
			file::forcemkdir ( dirname ( $path ) );
			mkdir ( $path, 0777 );
		}
	}
	// 检测文件是否存在
	function iswriteable($file) {
		$writeable = 0;
		if (is_dir ( $file )) {
			$dir = $file;
			if ($fp = @fopen ( "$dir/test.txt", 'w' )) {
				@fclose ( $fp );
				@unlink ( "$dir/test.txt" );
				$writeable = 1;
			}
		} else {
			if ($fp = @fopen ( $file, 'a+' )) {
				@fclose ( $fp );
				$writeable = 1;
			}
		}
		return $writeable;
	}
	// 删除当前目录下的文件或目录
	function cleardir($dir, $forceclear = false) {
		if (! is_dir ( $dir )) {
			return;
		}
		$directory = dir ( $dir );
		while ( $entry = $directory->read () ) {
			$filename = $dir . '/' . $entry;
			if (is_file ( $filename )) {
				@unlink ( $filename );
			} elseif (is_dir ( $filename ) & $forceclear & $entry != '.' & $entry != '..') {
				chmod ( $filename, 0777 );
				file::cleardir ( $filename, $forceclear );
				rmdir ( $filename );
			}
		}
		$directory->close ();
	}
	// 删除当前目录及目录下的文件
	function removedir($dir) {
		if (is_dir ( $dir ) && ! is_link ( $dir )) {
			if ($dh = opendir ( $dir )) {
				while ( ($sf = readdir ( $dh )) !== false ) {
					if ('.' == $sf || '..' == $sf) {
						continue;
					}
					file::removedir ( $dir . '/' . $sf );
				}
				closedir ( $dh );
			}
			return rmdir ( $dir );
		}
		return @unlink ( $dir );
	}
	
	//获取文件目录列表,该方法返回数组
	function getDir($dir) {
		$dirArray[]=NULL;
		if (false != ($handle = opendir ( $dir ))) {
			$i=0;
			while ( false !== ($file = readdir ( $handle )) ) {
				//去掉"“.”、“..”以及带“.xxx”后缀的文件
				if ($file != "." && $file != ".."&&!strpos($file,".")) {
					$dirArray[$i]=$file;
					$i++;
				}
			}
			//关闭句柄
			closedir ( $handle );
		}
		return $dirArray;
	}
	//获取文件列表
	function getFile($dir) {
		$fileArray[]=NULL;
		if (false != ($handle = opendir ( $dir ))) {
			$i=0;
			while ( false !== ($file = readdir ( $handle )) ) {
				//去掉"“.”、“..”以及带“.xxx”后缀的文件
				if ($file != "." && $file != ".."&&strpos($file,".")) {
					$fileArray[$i]= $file;
					if($i==100){
						break;
					}
					$i++;
				}
			}
			//关闭句柄
			closedir ( $handle );
		}
		return $fileArray;
	}
	
	//获取目录下所有文件，包括子目录
	public function get_allfiles($path,&$files) {
		if(is_dir($path)){
			$dp = dir($path);
			while ($file = $dp ->read()){
				if($file !="." && $file !=".."){
					$this->get_allfiles($path."/".$file, $files);
				}
			}
			$dp ->close();
		}
		if(is_file($path)){
			$files[] =  $path;
		}
	}
	public function get_filenamesbydir($dir){
		$files =  array();
		$this->get_allfiles($dir,$files);
		return $files;
	}
	
}