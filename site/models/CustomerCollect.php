<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%customer_collect}}".
 *
 * @property integer $collect_id
 * @property integer $user_id
 * @property integer $customer_id
 * @property string $transfer_note
 * @property integer $time
 * @property integer $status
 */
class CustomerCollect extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%customer_collect}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'customer_id', 'time', 'status'], 'integer'],
            [['transfer_note'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'collect_id' => 'Collect ID',
            'user_id' => 'User ID',
            'customer_id' => 'Customer ID',
            'transfer_note' => '扔回备注',
            'time' => 'Time',
            'status' => 'Status',
        ];
    }
}
