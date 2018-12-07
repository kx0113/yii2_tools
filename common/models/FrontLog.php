<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "front_log".
 *
 * @property integer $id
 * @property integer $token
 * @property string $url
 * @property integer $time
 * @property string $ip
 */
class FrontLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%front_log}}';

//        return 'front_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['time','token'], 'integer'],
            [['url', 'ip'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => '路由',
            'time' => '时间',
            'ip' => '访问ip',
            'token'=>'站点名称',
        ];
    }
}
