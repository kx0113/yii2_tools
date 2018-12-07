<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "kx_logs".
 *
 * @property string $id
 * @property string $user_id
 * @property string $module
 * @property string $action
 * @property string $message
 * @property string $data
 * @property string $ip
 * @property string $created_at
 * @property string $level
 */
class Logs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kx_logs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
//            [['module', 'action', 'message', 'ip', 'created_at', 'level'], 'required'],
            [['message', 'data','created_at'], 'string'],
            [['module', 'action'], 'string', 'max' => 32],
            [['ip'], 'string', 'max' => 255],
            [['level'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'module' => 'Module',
            'action' => 'Action',
            'message' => 'Message',
            'data' => 'Data',
            'ip' => 'Ip',
            'created_at' => 'Created At',
            'level' => 'Level',
        ];
    }
}
