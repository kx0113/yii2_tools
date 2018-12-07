<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "front_menu".
 *
 * @property integer $id
 * @property string $name
 * @property string $info
 * @property string $url
 * @property integer $sort
 * @property integer $user_id
 * @property integer $token
 * @property integer $add_time
 */
class FrontMenu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%front_menu}}';

//        return 'front_menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','url'], 'required'],
            [['sort', 'user_id', 'token', 'add_time','is_index','is_main'], 'integer'],
            [['name', 'info', 'url'], 'string', 'max' => 255],
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
            'info' => '简介',
            'url' => '路由',
            'sort' => '权重',
            'user_id' => '创建人',
            'token' => '网站名称',
            'add_time' => '创建时间',
        ];
    }
}
