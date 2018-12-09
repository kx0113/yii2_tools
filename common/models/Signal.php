<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "kx_signal".
 *
 * @property int $id
 * @property int $types 类型
 * @property string $name 名称
 * @property string $info 简介
 * @property string $desc1 文本1
 * @property string $desc2 文本2
 * @property string $create_time
 */
class Signal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kx_signal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['types'], 'integer'],
            [['desc1','desc2'], 'string'],
            [['create_time'], 'safe'],
            [['name', 'info'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'types' => Yii::t('app', 'Types'),
            'name' => Yii::t('app', 'Name'),
            'info' => Yii::t('app', 'Info'),
            'desc1' => Yii::t('app', 'Desc1'),
            'desc2' => Yii::t('app', 'Desc2'),
            'create_time' => Yii::t('app', 'Create Time'),
        ];
    }
}
