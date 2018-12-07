<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "news".
 *
 * @property integer $id
 * @property string $name
 * @property string $info
 * @property integer $type
 * @property integer $add_user
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $sort
 * @property integer $token
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%news}}';

//        return 'news';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'type'], 'required'],
            [['info','remark'], 'string'],
            [['type', 'add_user', 'create_time', 'update_time', 'sort', 'token'], 'integer'],
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
            'name' => '标题',
            'remark'=>'简介',
            'info' => '内容',
            'show_time' => '显示时间',
            'type' => '分类',
            'add_user' => '创建人',
            'create_time' => '创建时间',
            'update_time' => '修改时间',
            'sort' => '排序',
            'token' => '站点名称',
        ];
    }
    public static function addNews($web_id,$name,$type){
        $m=new News();
        $m->name=$name;
        $m->remark=$name.'简介';
        $m->info=$name.'详细信息';
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
