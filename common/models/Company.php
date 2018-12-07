<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "company".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $info
 * @property integer $add_user
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $token
 * @property integer $type
 */
class Company extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%company}}';

//        return 'company';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title','type','content','info'], 'required'],
            [['content','info'], 'string'],
            [['add_user', 'create_time', 'update_time', 'token', 'type'], 'integer'],
            [['title'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'info'=>'简介',
            'title' => '标题',
            'content' => '内容',
            'add_user' => '创建人',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
            'token' => '站点名称',
            'type' => '项目分类',
        ];
    }
    public static function addCompany($web_id,$name,$type){
        $m=new Company();
        $m->title=$name;
        $m->content=$name.'内容';
        $m->info=$name.'简介';
        $m->create_time=time();
        $m->add_user=yii::$app->user->identity->id;
        $m->token=$web_id;
        $m->type=$type;
        if($m->save()){
            return $m->id;
        }else{
            return false;
        }
    }
}
