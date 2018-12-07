<?php

namespace common\helps;

use Yii;

/**
 * 文件操作类:目录列表、文件列表、解压、移动、复制、删除
 * 
 * @author ken
 *        
 */
class FileManagerHelper {
	
	//静态单例模式
	private static $instance = NULL;
	//根目录
	private $rootDir = NULL;
	//真实的源路径
	private $id = NULL;
	//真实的目标路径
	private $id_aim = NULL;

	
	/**
	 * @desc 单例模式。外部调用的唯一入口
	 * @param unknown $id
	 * @param string $id_aim
	 */
	public static function getInstance()
	{
		if(self::$instance === null)
		{
			$classname = __CLASS__;
			self::$instance = new $classname();
		}
		return self::$instance;
	}
	
	/**
	 * @desc 获取真实路径
	 * @param unknown $path
	 * @return Ambigous <string, boolean>
	 */
	public function getRealPath($path, $overWrite = false){
		return file_exists($path) ? $path : ($overWrite == false ? self::$rootDir . DIRECTORY_SEPARATOR . $path : $path);
	}
	
	private function getPathById($path){
		return $this->rootDir . DIRECTORY_SEPARATOR . $path;
	}
	
	/**
	 * @desc 判断文件、目录是否存在
	 * @param string $file
	 * @return boolean
	 */
	function fileExist($id, $type = ''){
		if ($type == 'file') {
			return is_file($id);
		}elseif ($type == 'dir'){
			return is_dir($id);
		}else{
			return file_exists($id);
		}
	}
	
	/**
	 * @desc 判断目录是否为空(只有有文件时才不为空)
	 * @param unknown $dirname
	 */
	public function dirEmpty($dirname){
		//判断是否为一个目录，非目录直接关闭
		if(is_dir($dirname)){
			//如果是目录，打开他
			$name=opendir($dirname);
			//使用while循环遍历
			while($file=readdir($name)){
				//去掉本目录和上级目录的点
				if($file=="." || $file==".."){
					continue;
				}
				//如果目录里面还有一个目录，再次回调
				if(is_dir($dirname."/".$file)){
					$this->dirEmpty($dirname."/".$file);
				}
				//如果目录里面是个文件，那么输出文件名
				if(is_file($dirname."/".$file)){
					return false;
				}
			}
			//遍历完毕关闭文件
			closedir($name);
			//输出目录名
			 return true;
	 	}
	}
	
	/**
	 * @desc 获取目录下的文件列表(不包含目录)
	 * @param unknown $dir
	 * @return Ambigous <NULL, string>
	 */
	public function getFile($dir) {
		 $dirArray[]=NULL;
			if (false != ($handle = opendir ( $dir ))) {
				$i=0;
				while ( false !== ($file = readdir ( $handle )) ) {
					//去掉"“.”、“..”以及带“.xxx”后缀的文件
					if ($file != "." && $file != ".."&& strpos($file,".")) {
						$dirArray[$i]=$file;
						$i++;
					}
				}
				//关闭句柄
				closedir ( $handle );
			}
		return $dirArray;
	}
	
	/**
	 * 移动文件
	 *
	 * @param string $fileUrl
	 * @param string $aimUrl
	 * @param boolean $overWrite
	 *        	该参数控制是否覆盖原文件
	 * @return boolean
	 */
	function moveFile($overWrite = false) {
		if (! file_exists ( $this->id )) {
			return false;
		}
		if ((is_file($this->id_aim)) && $overWrite == false) {//如果目标文件已经存在,且不覆盖
			return false;
		} elseif (is_file ( $this->id_aim ) && $overWrite == true) {//如果目标文件已经存在,且覆盖
			$this->unlinkFile ( $this->id_aim );
		}
		$aimDir = dirname ( $this->id_aim );
		$this->createDir ( $aimDir );
		return rename ( $this->id, $this->id_aim);
	}
	
	/**
	 * 建立文件夹
	 *
	 * @param string $aimUrl        	
	 * @return viod
	 */
	function createDir($aimUrl, $mode = 0777) {
		$aimUrl = str_replace ( '', '/', $aimUrl );
		
		$aimDir = '';
		$arr = explode ( '/', $aimUrl );
		foreach ( $arr as $str ) {
			$aimDir .= $str . '/';
			if (! file_exists ( $aimDir )) {
				mkdir ( $aimDir, $mode );
			}
		}
		return true;
	}
	
	/**
	 * 建立文件
	 *
	 * @param string $aimUrl        	
	 * @param boolean $overWrite
	 *        	该参数控制是否覆盖原文件
	 * @return boolean
	 */
	function createFile($aimUrl, $overWrite = false) {
		if (file_exists ( $aimUrl ) && $overWrite == false) {
			return false;
		} elseif (file_exists ( $aimUrl ) && $overWrite == true) {
			$this->unlinkFile ( $aimUrl );
		}
		$aimDir = dirname ( $aimUrl );
		$this->createDir ( $aimDir );
		touch ( $aimUrl );
		return true;
	}
	
	/**
	 * 移动文件夹
	 *
	 * @param string $oldDir        	
	 * @param string $aimDir        	
	 * @param boolean $overWrite
	 *        	该参数控制是否覆盖原文件
	 * @return boolean
	 */
	function moveDir($oldDir, $aimDir, $overWrite = false) {
		$oldDir = $this->getRealPath($oldDir);
		$aimDir = $this->getRealPath($aimDir);
		
		$aimDir = str_replace ( '', '/', $aimDir );
		$aimDir = substr ( $aimDir, - 1 ) == '/' ? $aimDir : $aimDir . '/';
		$oldDir = str_replace ( '', '/', $oldDir );
		$oldDir = substr ( $oldDir, - 1 ) == '/' ? $oldDir : $oldDir . '/';
		if (! is_dir ( $oldDir )) {
			return false;
		}
		if (! file_exists ( $aimDir )) {
			$this->createDir ( $aimDir );
		}
		@$dirHandle = opendir ( $oldDir );
		if (! $dirHandle) {
			return false;
		}
		while ( false !== ($file = readdir ( $dirHandle )) ) {
			if ($file == '.' || $file == '..') {
				continue;
			}
			if (! is_dir ( $oldDir . $file )) {
				$this->moveFile ( $oldDir . $file, $aimDir . $file, $overWrite );
			} else {
				$this->moveDir ( $oldDir . $file, $aimDir . $file, $overWrite );
			}
		}
		closedir ( $dirHandle );
		return rmdir ( $oldDir );
	}
	
	/**
	 * 删除文件夹
	 *
	 * @param string $aimDir        	
	 * @return boolean
	 */
	function unlinkDir($aimDir) {
		$aimDir = str_replace ( '', '/', $aimDir );
		$aimDir = substr ( $aimDir, - 1 ) == '/' ? $aimDir : $aimDir . '/';
		if (! is_dir ( $aimDir )) {
			return false;
		}
		$dirHandle = opendir ( $aimDir );
		while ( false !== ($file = readdir ( $dirHandle )) ) {
			if ($file == '.' || $file == '..') {
				continue;
			}
			if (! is_dir ( $aimDir . $file )) {
				$this->unlinkFile ( $aimDir . $file );
			} else {
				$this->unlinkDir ( $aimDir . $file );
			}
		}
		closedir ( $dirHandle );
		return rmdir ( $aimDir );
	}
	
	/**
	 * 删除文件
	 *
	 * @param string $aimUrl        	
	 * @return boolean
	 */
	function unlinkFile($aimUrl) {
		if (file_exists ( $aimUrl )) {
			unlink ( $aimUrl );
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * 复制文件夹
	 *
	 * @param string $oldDir        	
	 * @param string $aimDir        	
	 * @param boolean $overWrite
	 *        	该参数控制是否覆盖原文件
	 * @return boolean
	 */
	function copyDir($oldDir, $aimDir, $overWrite = false) {
		$aimDir = str_replace ( '', '/', $aimDir );
		$aimDir = substr ( $aimDir, - 1 ) == '/' ? $aimDir : $aimDir . '/';
		$oldDir = str_replace ( '', '/', $oldDir );
		$oldDir = substr ( $oldDir, - 1 ) == '/' ? $oldDir : $oldDir . '/';
		if (! is_dir ( $oldDir )) {
			return false;
		}
		if (! file_exists ( $aimDir )) {
			$this->createDir ( $aimDir );
		}
		$dirHandle = opendir ( $oldDir );
		while ( false !== ($file = readdir ( $dirHandle )) ) {
			if ($file == '.' || $file == '..') {
				continue;
			}
			if (! is_dir ( $oldDir . $file )) {
				$this->copyFile ( $oldDir . $file, $aimDir . $file, $overWrite );
			} else {
				$this->copyDir ( $oldDir . $file, $aimDir . $file, $overWrite );
			}
		}
		return closedir ( $dirHandle );
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
	function copyFile($fileUrl, $aimUrl, $overWrite = false) {
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
		copy ( $fileUrl, $aimUrl );
		return true;
	}
	
	/**
	 * @desc 获取目录下的目录列表(不包含文件)
	 * @param unknown $dir
	 * @return Ambigous <NULL, string>
	 */
	/* 	function getDir($dir) {
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
	} */
	
	/**
	 * 将字符串写入文件
	 *
	 * @param string $filename
	 *        	文件名
	 * @param boolean $str
	 *        	待写入的字符数据
	 */
/* 	function writeFile($filename, $str) {
		if (function_exists ( file_put_contents )) {
			file_put_contents ( $filename, $str );
		} else {
			$fp = fopen ( $filename, "wb" );
			fwrite ( $fp, $str );
			fclose ( $fp );
		}
	} */
	
	/**
	 * 将整个文件内容读出到一个字符串中
	 *
	 * @param string $filename
	 *        	文件名
	 * @return array
	 */
/* 	function readsFile($filename) {
		if (function_exists ( file_get_contents )) {
			return file_get_contents ( $filename );
		} else {
			$fp = fopen ( $filename, "rb" );
			$str = fread ( $fp, filesize ( $filename ) );
			fclose ( $fp );
			return $str;
		}
	} */
	
	/**
	 * 将文件内容读出到一个数组中
	 *
	 * @param string $filename
	 *        	文件名
	 * @return array
	 */
/* 	function readFile2array($filename) {
		$file = file ( $filename );
		$arr = array ();
		foreach ( $file as $value ) {
			$arr [] = trim ( $value );
		}
		return $arr;
	} */
	
	/**
	 * 转化 \ 为 /
	 *
	 * @param string $path
	 *        	路径
	 * @return string 路径
	 */
/* 	function dirPath($path) {
		$path = str_replace ( '\\', '/', $path );
		if (substr ( $path, - 1 ) != '/')
			$path = $path . '/';
		return $path;
	} */
	
	/**
	 * 转换目录下面的所有文件编码格式
	 *
	 * @param string $in_charset
	 *        	原字符集
	 * @param string $out_charset
	 *        	目标字符集
	 * @param string $dir
	 *        	目录地址
	 * @param string $fileexts
	 *        	转换的文件格式
	 * @return string 如果原字符集和目标字符集相同则返回false，否则为true
	 */
/* 	function dirIconv($in_charset, $out_charset, $dir, $fileexts = 'php|html|htm|shtml|shtm|js|txt|xml') {
		if ($in_charset == $out_charset)
			return false;
		$list = $this->dirList ( $dir );
		foreach ( $list as $v ) {
			if (preg_match ( "/\.($fileexts)/i", $v ) && is_file ( $v )) {
				file_put_contents ( $v, iconv ( $in_charset, $out_charset, file_get_contents ( $v ) ) );
			}
		}
		return true;
	} */
	
	/**
	 * 列出目录下所有文件
	 *
	 * @param string $path
	 *        	路径
	 * @param string $exts
	 *        	扩展名
	 * @param array $list
	 *        	增加的文件列表
	 * @return array 所有满足条件的文件
	 */
/* 	function dirList($path, $exts = '', $list = array()) {
		$path = $this->dirPath ( $path );
		$files = glob ( $path . '*' );
		foreach ( $files as $v ) {
			$fileext = $this->fileext ( $v );
			if (! $exts || preg_match ( "/\.($exts)/i", $v )) {
				$list [] = $v;
				if (is_dir ( $v )) {
					$list = $this->dirList ( $v, $exts, $list );
				}
			}
		}
		return $list;
	} */
	
	/**
	 * 设置目录下面的所有文件的访问和修改时间
	 *
	 * @param string $path
	 *        	路径
	 * @param int $mtime
	 *        	修改时间
	 * @param int $atime
	 *        	访问时间
	 * @return array 不是目录时返回false，否则返回 true
	 */
/* 	function dirTouch($path, $mtime = TIME, $atime = TIME) {
		if (! is_dir ( $path ))
			return false;
		$path = $this->dirPath ( $path );
		if (! is_dir ( $path ))
			touch ( $path, $mtime, $atime );
		$files = glob ( $path . '*' );
		foreach ( $files as $v ) {
			is_dir ( $v ) ? $this->dirTouch ( $v, $mtime, $atime ) : touch ( $v, $mtime, $atime );
		}
		return true;
	} */
	
	/**
	 * 目录列表
	 *
	 * @param string $dir
	 *        	路径
	 * @param int $parentid
	 *        	父id
	 * @param array $dirs
	 *        	传入的目录
	 * @return array 返回目录及子目录列表
	 */
/* 	function dirTree($dir, $parentid = 0, $dirs = array()) {
		global $id;
		if ($parentid == 0)
			$id = 0;
		$list = glob ( $dir . '*' );
		foreach ( $list as $v ) {
			if (is_dir ( $v )) {
				$id ++;
				$dirs [$id] = array (
						'id' => $id,
						'parentid' => $parentid,
						'name' => basename ( $v ),
						'dir' => $v . '/' 
				);
				$dirs = $this->dirTree ( $v . '/', $id, $dirs );
			}
		}
		return $dirs;
	} */
	
	/**
	 * 目录列表
	 *
	 * @param string $dir
	 *        	路径
	 * @return array 返回目录列表
	 */
/* 	function dirNodeTree($dir) {
		$d = dir ( $dir );
		$dirs = array ();
		while ( false !== ($entry = $d->read ()) ) {
			if ($entry != '.' and $entry != '..' and is_dir ( $dir . '/' . $entry )) {
				$dirs [] = $entry;
			}
		}
		return $dirs;
	} */
	
	/**
	 * 获取目录大小
	 *
	 * @param string $dirname
	 *        	目录
	 * @return string 比特B
	 */
	function getDirSize($dirname) {
		if (! file_exists ( $dirname ) or ! is_dir ( $dirname ))
			return false;
		if (! $handle = opendir ( $dirname ))
			return false;
		$size = 0;
		while ( false !== ($file = readdir ( $handle )) ) {
			if ($file == "." or $file == "..")
				continue;
			$file = $dirname . "/" . $file;
			if (is_dir ( $file )) {
				$size += $this->getDirSize ( $file );
			} else {
				$size += filesize ( $file );
			}
		}
		closedir ( $handle );
		return $size;
	}
	
	function bitSize($size,$digits=2){ //digits，要保留几位小数
		$unit= array('','K','M','G','T','P');//单位数组，是必须1024进制依次的哦。
		$base= 1024;//对数的基数
		$i   = floor(log($size,$base));//字节数对1024取对数，值向下取整。
		return $size == 0 ? 0 . 'B' : round($size/pow($base,$i),$digits).' '.$unit[$i] . 'B';
	}
	/**
	 * 获取文件名后缀
	 *
	 * @param string $filename        	
	 * @return string
	 */
/* 	function fileext($filename) {
		return addslashes ( trim ( substr ( strrchr ( $filename, '.' ), 1, 10 ) ) );
	}
	function remote_file_exists($url_file) {
		$url_file = trim ( $url_file );
		if (empty ( $url_file ))
			return false;
		$url_arr = parse_url ( $url_file );
		if (! is_array ( $url_arr ) || empty ( $url_arr ))
			return false;
		$host = $url_arr ['host'];
		$path = $url_arr ['path'] . "?" . $url_arr ['query'];
		$port = isset ( $url_arr ['port'] ) ? $url_arr ['port'] : "80";
		$fp = fsockopen ( $host, $port, $err_no, $err_str, 30 );
		if (! $fp)
			return false;
		$request_str = "GET " . $path . " HTTP/1.1\r\n";
		$request_str .= "Host:" . $host . "\r\n";
		$request_str .= "Connection:Close\r\n\r\n";
		fwrite ( $fp, $request_str );
		// fread replace fgets
		$first_header = fread ( $fp, 128 );
		fclose ( $fp );
		if (trim ( $first_header ) == "")
			return false;
			// check $url_file "Content-Location"
		if (! preg_match ( "/200/", $first_header ) || preg_match ( "/Location:/", $first_header ))
			return false;
		return true;
	} */
}
	