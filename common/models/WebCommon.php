<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "web_common".
 *
 * @property integer $id
 * @property string $logo
 * @property string $banner
 * @property string $tmp_file
 * @property string $tel
 * @property string $footer
 * @property integer $token
 */
class WebCommon extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%web_common}}';

//        return 'web_common';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['banner', 'footer'], 'string'],
            [['token'], 'integer'],
            [['logo', 'tel'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'logo' => 'Logo',
            'banner' => 'Banner',
            'tel' => 'Tel',
            'footer' => 'Footer',
            'token' => 'Token',
        ];
    }
}
