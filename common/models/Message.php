<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "kx_message".
 *
 * @property string $id
 * @property string $company
 * @property string $username
 * @property string $mobile
 * @property string $qq
 * @property string $content
 * @property string $ip
 * @property string $create_at
 * @property string $delete_at
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kx_message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['create_at', 'delete_at'], 'safe'],
            [['company', 'username', 'mobile', 'qq', 'ip'], 'string', 'max' => 50],
            [['content'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company' => 'Company',
            'username' => 'Username',
            'mobile' => 'Mobile',
            'qq' => 'Qq',
            'content' => 'Content',
            'ip' => 'Ip',
            'create_at' => 'Create At',
            'delete_at' => 'Delete At',
        ];
    }
}
