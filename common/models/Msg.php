<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "kx_msg".
 *
 * @property integer $id
 * @property string $name
 * @property string $iphone
 * @property string $msg
 * @property string $ip
 * @property string $create_at
 */
class Msg extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kx_msg';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['create_at'], 'safe'],
            [['name', 'iphone'], 'string', 'max' => 40],
            [['msg'], 'string', 'max' => 255],
            [['ip'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'iphone' => 'Iphone',
            'msg' => 'Msg',
            'ip' => 'Ip',
            'create_at' => 'Create At',
        ];
    }
}
