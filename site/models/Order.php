<?php

namespace frontend\models;

use Yii;
use app\models\OrderBatch;
use app\models\Product;
use app\models\Organization;
use app\models\FinancialPayment;
use app\models\SoleInfo;
use mdm\admin\models\User;
use yii\helpers\Dhtools;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "{{%order}}".
 *
 * @property string $order_id
 * @property string $order_sn
 * @property integer $start_user_id
 * @property string $start_user_name
 * @property integer $product_id
 * @property integer $company_id
 * @property string $company_name
 * @property string $company_code
 * @property integer $department_id
 * @property string $department_name
 * @property string $department_code
 * @property integer $ordertype_id
 * @property string $ordertype_code
 * @property integer $orderfrom_id
 * @property integer $store_unquire_id
 * @property string $store_name
 * @property integer $store_platform_id
 * @property string $store_url
 * @property integer $store_level_id
 * @property integer $store_category_id
 * @property integer $store_create_time
 * @property integer $store_provinceid
 * @property integer $store_cityid
 * @property string $store_address_info
 * @property integer $hasstore
 * @property integer $customer_id
 * @property string $customer_name
 * @property integer $customer_contact_tel
 * @property string $customer_aliww
 * @property integer $customer_sex
 * @property integer $customer_qq
 * @property string $customer_name_bak
 * @property integer $customer_contact_tel_bak
 * @property string $customer_aliww_bak
 * @property integer $customer_qq_bak
 * @property string $service_content_id
 * @property string $services_content_detail
 * @property string $order_marks
 * @property integer $order_date
 * @property string $order_price
 * @property integer $orderdb_type
 * @property string $order_cycle_time
 * @property string $order_avg_mounth_price
 * @property integer $order_give_cycle_time
 * @property string $day_limit
 * @property integer $is_service_market
 * @property integer $extend_goods_num
 * @property integer $hasattachment
 * @property string $attachment_content
 * @property integer $hasfinancial
 * @property string $financial_payment_content
 * @property integer $order_state
 * @property string $order_attribution
 * @property string $entity_contract
 * @property string $related_order
 */
class Order extends \yii\db\ActiveRecord
{
    public $date_range;
    public $batch_state;
    public $newbatch_state;
    public $is_submit;
    public $order_flow_code;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_sn', 'start_user_id', 'product_id', 'company_id',  'ordertype_id','service_content_id',  'extend_goods_num', 'entity_contract'], 'required'],
            [[ 'start_user_id', 'product_id', 'company_id',  'ordertype_id', 'orderfrom_id', 'hasstore', 'customer_id', "time", /*'order_date',*/ 'orderdb_type',/* 'order_give_cycle_time',*/ 'is_service_market', 'extend_goods_num', 'hasattachment', 'hasfinancial', 'order_state','batch_state','newbatch_state','is_submit'], 'integer'],
            ['entity_contract','unique','message'=>'实体合同不能重复'],
            [['order_price', 'order_avg_mounth_price', 'day_limit'], 'number'],
            [['start_user_name', 'ordertype_code',  "order_flow_code", 'financial_payment_content'], 'string', 'max' => 20],
            [[  'entity_contract', 'related_order','marking'], 'string', 'max' => 200],
        
            [['services_content_detail', 'order_attribution'], 'string', 'max' => 200],
            [['order_marks'], 'string', 'max' => 500],
            [['attachment_content'], 'file','extensions' => 'jpg,png','maxSize'=>1024000,'checkExtensionByMimeType'=>false],
            [['date_range'], 'string'],

            [['order_marks','hasfinancial','orderdb_type','order_price','order_cycle_time','order_date'],'required', 'when' => function ($model, $attribute) {
              
                return $model->ordertype_id != '1';
            }, 'whenClient' => "function (attribute, value) {
                return $('#order-ordertype_id').val() != '1';
            }"]


            //[['store_unquire_id'],'requiredByASpecial', 'skipOnEmpty' => false, 'skipOnError' => false],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => 'Order ID',
            'order_sn' => '订单编号',
            'start_user_id' => 'Start User ID',
            'start_user_name' => '订单发起人',
            'product_id' => '服务类型',
            'department_id' => '审核部门',
            'company_id' => '操作人',
            'ordertype_id' => '内外单类型',
            'ordertype_code' => 'Ordertype Code',
            'orderfrom_id' => '订单来源',
            'store_unquire_id' => '店铺唯一id',
            'hasstore' => 'Hasstore',
            'customer_id' => 'Customer ID',
            'service_content_id' => '服务内容',
            'services_content_detail' => 'Services Content Detail',
            'order_marks' => '客户需求',
            'order_date' => '签约时间',
            'order_price' => '签约服务费',
            'orderdb_type' => '签约类型',
            'order_cycle_time' => '订单周期',
            'order_avg_mounth_price' => 'Order Avg Mounth Price',
            'order_give_cycle_time' => 'Order Give Cycle Time',
            'day_limit' => 'Day Limit',
            'is_service_market' => 'Is Service Market',
            'extend_goods_num' => '直通车推广宝贝数量',
            'hasattachment' => 'Hasattachment',
            'attachment_content' => 'Attachment Content',
            'hasfinancial' => '回款信息',
            'financial_payment_content' => 'Financial Payment Content',
            'order_state' => '状态',
            'order_attribution' => 'Order Attribution',
            'entity_contract' => '实体合同',
            'related_order' => 'Related Order',
            'time' => '发起时间',
            'marking' => '订单标识',
        ];
    }


    /**
     *  自定义验证B
     */
    /*public function requiredByASpecial($attribute, $params)
    {
        if ($this->product_id== 4) 
        {
            if ($this->store_unquire_id=== '')
                $this->addError($attribute, "B的值不可以为空.");
        }
    }*/


     // 这是获取订单记录，一个订单有多个记录
    public function getOrderBatch()
    {
        // 第一个参数为要关联的子表模型类名，
        // 第二个参数指定 通过子表的customer_id，关联主表的id字段
        return $this->hasMany(OrderBatch::className(), ['order_id' => 'order_id']);
    }
    

    /**
    *获取下级审批部门
    **/

    public static function get_department($id){
        $orderbatch = OrderBatch::find()->where(['order_id'=>$id])->orderBy('batch_id desc')->asArray()->One();
        $department = Organization::find()->where(['id'=>$orderbatch['next_department_id']])->asArray()->One();
        return $department['name'];
    }

    /**
    *获取订单审批操作人
    **/

    public static function get_user($id){
        $orderbatch = OrderBatch::find()->where(['order_id'=>$id])->orderBy('batch_id desc')->asArray()->One();

        $user = User::find()->where(['id'=>$orderbatch['batcher_user']])->asArray()->One();

        if (!empty($user) && is_array($user)) {
            return $user['truename'];
        }else{
            return '暂无操作';
        }
    }
    public static function get_user1($id){
//        $orderbatch = OrderBatch::find()->where(['order_id'=>$id])->orderBy('batch_id desc')->asArray()->One();

        $user = User::find()->where(['id'=>$id])->asArray()->One();

        if (!empty($user) && is_array($user)) {
            return $user['truename'];
        }else{
            return '暂无操作';
        }
    }
    public static function get_truename($id){
    
        $order = Order::find()->where(['order_id'=>$id])->asArray()->One();
        if (!empty($order) && is_array($order)) {
             return $order['start_user_name'];   
        }else{
            return '暂无操作';
        }
    }
    public static function get_time($id){
        $order = Order::find()->where(['order_id'=>$id])->asArray()->One();
        if (!empty($order) && is_array($order)) {
             return date('Y-m-d',$order['time']);   
        }else{
            return '暂无操作';
        }
    }
    public static function get_batch_state($id){
         $orderbatch = OrderBatch::find()->where(['order_id'=>$id])->orderBy('batch_id desc')->asArray()->One();
        if ($orderbatch['batch_state'] == 0) {
            if ($orderbatch['is_submit'] >= 0 && $orderbatch['is_submit'] <= 4) {
                return '进入待审核';
            }
        }elseif ($orderbatch['batch_state'] == 1) {
            if ($orderbatch['is_submit'] >= 0 && $orderbatch['is_submit'] <= 4) {
                return '通过';
            }elseif ($orderbatch['is_submit'] == 5) {
                return '订单到期';
            }
        }elseif ($orderbatch['batch_state'] == 2) {
            if ($orderbatch['is_submit'] >= 0 && $orderbatch['is_submit'] <= 4) {
                return '打回';
            }
        }elseif ($orderbatch['batch_state'] == 3) {
            if ($orderbatch['is_submit'] >= 0 && $orderbatch['is_submit'] <= 4) {
                return '提交审核';
            }
        }elseif ($orderbatch['batch_state'] == 4) {
            if ($orderbatch['is_submit'] >= 0 && $orderbatch['is_submit'] <= 4) {
                return '结束审核';
            }
        }elseif ($orderbatch['batch_state'] == 5) {
            if ($orderbatch['is_submit'] >= 0 && $orderbatch['is_submit'] <= 4) {
                return '分配开始';
            }
        }elseif ($orderbatch['batch_state'] == 6) {
            if ($orderbatch['is_submit'] >= 0 && $orderbatch['is_submit'] <= 4) {
                return '分配中';
            }
        }elseif ($orderbatch['batch_state'] == 7) {
            if ($orderbatch['is_submit'] >= 0 && $orderbatch['is_submit'] <= 4) {
                return '分配结束';
            }
        }
    }
    public static function get_product($id){
        $order = Order::find()->where(['order_id'=>$id])->asArray()->One();
        $datas = Product::find()->where(['product_id'=>$order['product_id']])->One();
        return  $datas['product_name'];
       
    }

    public static function get_state($id){
        $order = Order::find()->where(['order_id'=>$id])->asArray()->One();
        $soloinfo = SoleInfo::find()->where(['sole_info_name'=>$order['order_state']])->asArray()->One();
        return  $soloinfo['sole_info_note'];
    }
    public static function get_order_flow_code($id){
        $orderbatch = OrderBatch::find()->where(['batch_id'=>$id])->asArray()->One();
        return  $orderbatch['order_flow_code'];
    }
    public static function get_order_status($id){
        $orderbatch = Order::find()->where(['customer_id'=>$id])->asArray()->One();
        if($orderbatch){
            return date('Y-m-d',$orderbatch['time']);
        }else{
            return '未合作';
        }
    }
    public static function get_store_id($id){
        $order = Order::find()->where(['order_id'=>$id])->asArray()->One();
        return  $order['store_unquire_id'];
    }
}
