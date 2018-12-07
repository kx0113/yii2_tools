<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "company_type".
 *
 * @property integer $id
 * @property string $name
 * @property integer $sort
 * @property integer $token
 */
class CompanyType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%company_type}}';

//        return 'company_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['sort', 'token','create_at','user_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
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
            'sort' => '排序',
            'token' => '站点名称',
            'create_at' => '创建时间',
            'user_id' => '创建人',
        ];
    }
    public static function get_type_name($id){
        $session=Yii::$app->session;
        $res=CompanyType::find()->select('name')->where(['id'=>$id,'token'=>$session->get('web_id')])->asArray()->one();
        return $res['name'];
    }
    public function get_type_list(){
        $session=Yii::$app->session;
        $new_list=CompanyType::find()->where(['token'=>$session->get('web_id')])->all();
        $result = ArrayHelper::map(array_merge(array(array('id'=>'','name'=>'- 请选择 -')),$new_list), 'id', 'name');
        return $result;
    }
    public static function addCompanyType($web_id,$name){
        $model=new CompanyType();
        $model->name=$name;
        $model->user_id=yii::$app->user->identity->id;
        $model->create_at=time();
        $model->token=$web_id;
        if($model->save()){
            return $model->id;
        }else{
            return false;
        }
    }
}
