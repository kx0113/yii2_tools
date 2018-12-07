<?php
namespace common\helps;

use Yii;
use moonland\phpexcel\Excel;//excel 导入导出

class phpexcel{
	
	//单例模式
	private static $instance = NULL;
	
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
	 * @desc 导出excel.使用方法如下
	 * 1、对象类型：
	 * $categoryModel = Category::find()->all();
    	$columns = [
		    	'cid' => '分类ID',
		    	'parent_id' => '父级分类ID',
		    	'category_name' => '分类名称',
		    	'att' => '附件',
		    	'create_time' => '创建时间',
	    	];
    	$headers = [
	    			'cid',
			    	'parent_id',
			    	'category_name',
			    	'att',
			    	'create_time',
	    	]; 
	 * 
	 * 2、数组类型：
			$data = [
	    		['cid'=>1, 'parent_id'=>11, 'name'=>'test1'],
	    		['cid'=>2, 'parent_id'=>22, 'name'=>'test2'],
	    		['cid'=>3, 'parent_id'=>33, 'name'=>'test3'],
	    	];
	    	$columns = [
	    		'cid'=>'分类id',
	    		'name'=>'名字'
	    	];
	    	$headers = [
	    		'cid',
	    		'name'
	    	];
	 * 
	 * @param object || array $models 对象模型(支持数组类型)
	 * @param array $headers 导出的列头说明
	 * @param array $columns 需要导出的列
	 */
	public function export($models, $headers, $columns){
		if (empty($models) || empty($columns) || empty($headers)) {
			return false;
		}
		Excel::export(
			[
				'models'=>$models, 
				'headers'=>$headers,
				'columns'=>$columns
			]
		);
	}
	
	/**
	 * @desc 导入(把excel数据转换成可操做的数组)
	 * @param string $fileName  excel 文件名
	 * 
	 * $fileName = '/srv/www/advanced/doc/exports.xls';
       $data = phpexcel::getInstance()->import($fileName);
    	
	 * @return array
	 * 
	 * Array
		(
		    [0] => Array
		        (
		            [分类ID] => 1
		            [父级分类ID] => 111222
		            [分类名称] => 食物分类12222233
		            [附件] => 
		            [创建时间] => 2016-08-09 18:14:02
		        )
		
		    [1] => Array
		        (
		            [分类ID] => 2
		            [父级分类ID] => 2
		            [分类名称] => 汽车
		            [附件] => 
		            [创建时间] => 2016-07-27 17:29:19
		   )
        
	 */
	public function import($fileName){
		if (empty($fileName) || file_exists($filename)) 
			return false;
		$data = Excel::import($fileName, ['setFirstRecordAsKeys' => true]);
		return $data;
	}
	

	/**
	 * @desc 多工作薄解析excel文件  并返回解析后返回的数据
	 * @param unknown $fileName  文件地址名称
	 * @param array $sheetIndex 工作薄数组eg: [0,1,2]
	 * @return boolean
	 */
	public function readExcel($fileName,$sheetIndex=array()){
		$fileName=str_replace('\\', '/', $fileName);
		if ( !file_exists($fileName) || empty($sheetIndex))
			return false;
		$excelobj= new Excel();
		$excelData=$excelobj->readFile($fileName);//返回excel数
		$finance = Yii::$app->params ['financeManage']; // 获取配置信息
		$exceldata=$excelobj->executeGetOnlyRecords($excelData,$sheetIndex);
		return $exceldata;
	}

    /**
     * @desc 单个工作薄解析excel文件  并返回解析后返回的数据
     * @param unknown $fileName  文件地址名称
     * @return boolean
     */
    public function readSingleSheetExcel($fileName){
        $fileName=str_replace('\\', '/', $fileName);
        if ( !file_exists($fileName))
            return false;
        $excelobj= new Excel();
        $excelData=$excelobj->readFile($fileName);//返回excel数
        return $excelData;
    }
	
}