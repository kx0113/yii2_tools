<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "product_type".
 *
 * @property integer $id
 * @property string $name
 * @property string $info
 * @property integer $parent
 * @property integer $add_time
 * @property integer $add_user
 * @property integer $token
 */
class ProductType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product_type}}';

//        return 'product_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['add_time', 'add_user', 'token','parent'], 'integer'],
            [['name', 'info'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '分类名称',
            'info' => '简介',
            'add_time' => '创建时间',
            'add_user' => '创建人',
            'parent'=>'一级分类',
            'token' => '网站名称',
        ];
    }
    public function get_type_list(){
        $session=Yii::$app->session;
        $new_list=ProductType::find()->where(['token'=>$session->get('web_id')])->andWhere(['<>','parent',0])->all();
        $result = ArrayHelper::map(array_merge(array(array('id'=>'','name'=>'- 请选择 -')),$new_list), 'id', 'name');
        return $result;
    }
    public function get_type_list1(){
        $session=Yii::$app->session;
        $new_list=ProductType::find()->where(['parent'=>0,'token'=>$session->get('web_id')])->all();
        $result = ArrayHelper::map(array_merge(array(array('id'=>'0','name'=>'- 请选择 -')),$new_list), 'id', 'name');
        return $result;
    }
    public static function get_type_name($id){
        $session=Yii::$app->session;
        $res=ProductType::find()->select('name')->where(['id'=>$id,'token'=>$session->get('web_id')])->asArray()->one();
        return $res['name'];
    }
    public static function addProductType($web_id,$name,$parent){
        $model=new ProductType();
        $model->name=$name;
        $model->parent=$parent;
        $model->add_user=yii::$app->user->identity->id;
        $model->add_time=time();
        $model->token=$web_id;
        if($model->save()){
            return $model->id;
        }else{
            return false;
        }
    }
}
