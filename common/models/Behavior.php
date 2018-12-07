<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "kx_behavior".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $behavior
 * @property string $time
 * @property string $url
 * @property integer $status
 * @property string $ip
 * @property integer $tid
 */
class Behavior extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kx_behavior';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'status', 'tid'], 'integer'],
            [['time'], 'safe'],
            [['behavior', 'url'], 'string', 'max' => 100],
            [['ip'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'behavior' => 'Behavior',
            'time' => 'Time',
            'url' => 'Url',
            'status' => 'Status',
            'ip' => 'Ip',
            'tid' => 'Tid',
        ];
    }
}
