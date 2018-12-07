<?php

namespace frontend\models;

use Yii;


use yii\helpers\ArrayHelper; //设置值，获取值
/**
 * This is the model class for table "{{%sole}}".
 *
 * @property integer $sole_id
 * @property string $sole_title
 * @property string $sole_name
 * @property integer $sole_state
 */
class Sole extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sole}}';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sole_title', 'sole_name'], 'required'],
            [['sole_state','sole_sort'], 'integer'],
            [['sole_title', 'sole_name'], 'string', 'max' => 20],
            [['sole_name'],'unique','message'=>'{attribute}已有重复'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sole_id' => '类型id',
            'sole_title' => '唯一备注',
            'sole_name' => '唯一名称',
            'sole_sort' => '排序',
            'sole_state' => '状态',
        ];
    }

}
