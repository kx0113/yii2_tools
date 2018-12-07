<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "new_type".
 *
 * @property integer $id
 * @property string $name
 * @property integer $add_user
 * @property integer $create_at
 * @property integer $token
 * @property integer $sort
 */
class NewType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%new_type}}';

//        return 'new_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name',], 'required'],
            [['add_user', 'create_at', 'token', 'sort'], 'integer'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'add_user' => '创建人',
            'create_at' => '创建时间',
            'token' => '网站名称',
            'sort' => '排序',
        ];
    }
    public static function get_type_name($id){
        $session=Yii::$app->session;
        $res=NewType::find()->select('name')->where(['id'=>$id,'token'=>$session->get('web_id')])->asArray()->one();
        return $res['name'];
    }
    public function get_type_list(){
        $session=Yii::$app->session;
        $new_list=NewType::find()->where(['token'=>$session->get('web_id')])->all();
        $result = ArrayHelper::map(array_merge(array(array('id'=>'','name'=>'- 请选择 -')),$new_list), 'id', 'name');
        return $result;
    }
    public static function addNewsType($web_id,$name){
        $model=new NewType();
        $model->name=$name;
        $model->add_user=yii::$app->user->identity->id;
        $model->create_at=time();
        $model->token=$web_id;
        if($model->save()){
            return $model->id;
        }else{
            return false;
        }
    }
}
