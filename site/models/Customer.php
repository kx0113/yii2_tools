<?php

namespace frontend\models;

use Yii;
use yii\helpers\ArrayHelper;
use app\models\CustomerCompany;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use mdm\admin\models\User;
// use app\Models\SoleInfo;
/**
 * This is the model class for table "wo_services_content".
 *
 * @property integer $services_content_id
 * @property string $services_content_name
 * @property integer $product_id
 * @property string $services_content_mark
 * @property integer $sort
 */

class Customer extends \yii\db\ActiveRecord
{
    public $parshwodata;
    public $company_name;
//    public $customer_id;
    public $store_time1;
    public $customer_store_id_1;
    public $customer_store_id_2;
    public $customer_store_id_3;
    public $customer_store_id_4;
    public $next_time;
    public $d_time;
    public $department_id;
    public $product_name;
    public $customer_company_id_str;
    public $company_id;
    public $submit_time;
    public $customer_company_id_store;
    public $department_idr;
    public $department_idrw;
   // public $customer_company_id;
    /**
     * @inheritdoc
     */

    public static function tableName()
    {
        return 'wo_customer';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[/*'customer_id',*/'customer_name_bak','customer_contact_tel_bak','customer_aliww_bak','customer_level_id','call_type'], 'required'],

            [['customer_hac_company','entering_user','customer_company_id','customer_sex','customer_level_id','time'], 'integer'],

          [['customer_name','customer_name_bak',], 'string', 'max' => 50],
            ['customer_contact_tel_bak','unique','message'=>'联系人不能重复'],
            ['customer_aliww_bak','unique','message'=>'联系人旺旺不能重复'],
            ['store_unquire_id','unique','message'=>'淘宝旺旺ID不能重复'],
            [['customer_aliww','customer_contact_tel','customer_contact_tel_2','customer_qq','customer_wechat','customer_contact_tel_bak','customer_aliww_bak','customer_qq_bak','customer_wechat_bak'], 'string', 'max' => 50],

            ['customer_contact_tel','match','pattern'=>'/^(400(-\d{3,4}){2})|(0\d{2,3}-[2-9][0-9]{6,7})|(0\d{2,3}[2-9][0-9]{6,7})|([2-9][0-9]{6,7})|(1[35847]\d{9})$/','message'=>'{attribute}电话号码格式不正确'],

            ['customer_contact_tel_2','match','pattern'=>'/^(400(-\d{3,4}){2})|(0\d{2,3}-[2-9][0-9]{6,7})|(0\d{2,3}[2-9][0-9]{6,7})|([2-9][0-9]{6,7})|(1[35847]\d{9})$/','message'=>'{attribute}电话号码格式不正确'],

            ['customer_contact_tel_bak','match','pattern'=>'/^(400(-\d{3,4}){2})|(0\d{2,3}-[2-9][0-9]{6,7})|(0\d{2,3}[2-9][0-9]{6,7})|([2-9][0-9]{6,7})|(1[35847]\d{9})$/','message'=>'{attribute}电话号码格式不正确'],

             ['customer_contact_tel_bak','match','pattern'=>'/^1[0-9]{10}$/','message'=>'必须为1开头的11位纯数字'],

            ['customer_qq','match','pattern'=>'/^[1-9][0-9]{4,}$/','message'=>'{attribute}QQ格式不正确'],
           ['customer_qq_bak','match','pattern'=>'/^[1-9][0-9]{4,}$/','message'=>'{attribute}QQ格式不正确'],


            [['customer_level'], 'string','max' => 2],

            [['customer_feature'], 'string','max' => 50],

            [['store_name','store_category_id','store_url','store_unquire_id'], 'required', 'when' => function ($model, $attribute) {
                return $model->customer_hac_company == '0';
            }, 'whenClient' => "function (attribute, value) {
                return $('#customer-customer_hac_company').val() == '0';
            }"]
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
       return [
            'customer_id' => '客户id',
            'customer_name' => '掌柜姓名',
            'customer_contact_tel' => '掌柜联系电话',
            'customer_contact_tel_2' => '掌柜备用电话',
            'customer_sex' => '掌柜性别',
            'customer_aliww' => '掌柜阿里旺旺',
            'customer_qq' => '掌柜QQ ',
            'customer_wechat' => '掌柜微信',
            'customer_name_bak' => '主要联系人',
            'customer_contact_tel_bak'=>'手机号码',
            'customer_aliww_bak'=>'客户唯一ID',
            'customer_qq_bak'=>'联系人QQ ',
            'customer_wechat_bak'=>'联系人微信 ',
            'customer_level_id'=>'客户级别',
            'customer_level'=>'客户级别',
            'customer_feature'=>'客户简介',
            'customer_hac_company'=>'是否有淘宝店铺',
            'user_id' => '所属人员',
            'is_excel' => '数据来源',
            'collect_num' => '采集次数',
            'time' => '新增时间',
            'entering_user' => '录入人',
            'store_unquire_id' => '淘宝旺旺id',
            'store_name' => '店铺名称',
            'store_url' => '店铺连接',
            'store_category_id' => '店铺类目',
            'call_type' => '呼入/呼出',
        ];
    }
    public static  function  get_type(){
        $customer = CustomerCompany::find()->all();
        $customer = ArrayHelper::map($customer, 'company_id', 'company_name');
        return $customer;
    }

    public static  function  get_type_text($id){
        $datas = CustomerCompany::find($id)->all(); 
        $datas = ArrayHelper::map($datas, 'company_id', 'company_name');
        return  $datas[$id];

    }



    public static  function  get_sex_text($id){
        if ($id==1){
            $datas[$id]='男';
        }else if($id==2){
            $datas[$id]='女';
        } else{
            $datas[$id]='不限';
        }    
        return  $datas[$id];

    }


   // public static  function  get_type_hascom(){
   //      $hascom['1']='注册';
   //      $hascom['2']='未注册';
   //      return $hascom;
   //  }
    public static  function  get_type_hascom_text($id){
        if ($id==1){
            $datas[$id]='注册';
        }else if($id==0){
            $datas[$id]='未注册';
        }     
        return  $datas[$id];

    }

    public static  function  get_type_level(){
        $customer = SoleInfo::find()->where(['sole_name'=>'customer_level'])->all();
        $customer = ArrayHelper::map($customer, 'sole_info_id', 'sole_info_name');
        return $customer;
    }
    //获取人员名称
    public static function get_user_name($user_id){
        $user_info = User::find()->where(['id'=>$user_id])->asArray()->One();
        return $user_info['truename'];
    }
    //获取公司名称
    public static function get_company($company_id){
        $company_info = CustomerCompany::find()->where(['company_id'=>$company_id])->asArray()->One();
        return $company_info['company_name'];
    }

}
