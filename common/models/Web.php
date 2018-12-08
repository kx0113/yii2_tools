<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "web".
 *
 * @property integer $id
 * @property string $name
 * @property integer $sort
 * @property string $intro
 * @property string $logo
 */
class Web extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%web}}';

//        return 'web';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['sort','status'], 'integer'],
            [['name','weburl'], 'string', 'max' => 50],
            [['intro','logo'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'weburl' => '网站url',
            'status' => '状态',
            'version' => '版本',
            'sort' => '排序',
            'intro' => '简介',
        ];
    }
    public static function GetWebName($id){
        $res=Web::find()->where(['id'=>$id])->asArray()->one();
        return $res['name'];
    }
}
