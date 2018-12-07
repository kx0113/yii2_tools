<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "config".
 *
 * @property integer $id
 * @property integer $token
 * @property string $params
 * @property integer $limit
 * @property integer $add_time
 * @property integer $add_user
 * @property string $models
 */
class Config extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%config}}';

//        return 'config';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['params','limit','models'], 'required'],
            [['token', 'limit','add_time','add_user'], 'integer'],
            [['models','params'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'token' => '网站名称',
            'params' => '参数',
            'limit' => '限制',
            'models' => '模块',
            'add_time'=>'创建时间',
            'add_user'=>'创建人',
        ];
    }
}
