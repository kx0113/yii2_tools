<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "kx_visit".
 *
 * @property integer $id
 * @property string $url
 * @property integer $status
 * @property string $ip
 * @property string $create_at
 * @property string $remark
 */
class Visit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%visit}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['create_at'], 'safe'],
            [['url', 'from'], 'string', 'max' => 100],
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
            'url' => 'Url',
            'status' => 'Status',
            'ip' => 'Ip',
            'create_at' => 'Create At',
            'remark' => 'Remark',
        ];
    }
}
