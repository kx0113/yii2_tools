<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "key_word".
 *
 * @property integer $id
 * @property string $title
 * @property integer $token
 * @property integer $add_time
 * @property integer $update_time
 * @property integer $add_user
 */
class KeyWord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%key_word}}';

//        return 'key_word';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title',], 'required'],
            [['token', 'add_time', 'update_time', 'add_user'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '关键词',
            'token' => '网站名称',
            'add_time' => '创建时间',
            'update_time' => '更新时间',
            'add_user' => '创建人',
        ];
    }
}
