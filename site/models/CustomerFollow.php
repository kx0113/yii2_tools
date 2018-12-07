<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Customer;

/**
 * This is the model class for table "wo_customer_follow".
 *
 * @property integer $follow_id
 * @property integer $user_id
 * @property integer $customer_id
 * @property string $follow_content
 * @property integer $follow_type
 * @property string $next_time
 * @property string $submit_time
 */
class CustomerFollow extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wo_customer_follow';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'customer_id', 'follow_content', 'follow_type', /*'next_time', */'submit_time'], 'required'],
            [['user_id', 'customer_id', 'follow_type'], 'integer'],
            [['follow_content', 'next_time', 'submit_time'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'follow_id' => 'id自增',
            'user_id' => '用户id',
            'customer_id' => '客户id',
            'follow_content' => '沟通内容',
            'follow_type' => '沟通方试，1电话，2网络',
            'next_time' => '下次沟通时间',
            'submit_time' => '添加记录时间',
        ];
    }
     public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params,$user)
    {
        if ($user == 0) {
           $query = Customer::find()->where(['user_id'=>0]);
        }elseif ($user >0) {
           $query = Customer::find()->where(['user_id'=>$user]);
        }
        

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'customer_level' => $this->customer_level,
        ]);

        $query->andFilterWhere(['like', 'customer_name', $this->customer_name])
                ->andFilterWhere(['like', 'customer_contact_tel', $this->customer_contact_tel])
                ->andFilterWhere(['like', 'customer_name_bak', $this->customer_name_bak])
                ->andFilterWhere(['like', 'customer_contact_tel_bak', $this->customer_contact_tel_bak])
                ->andFilterWhere(['like', 'customer_aliww_bak', $this->customer_aliww_bak]);

        return $dataProvider;
    }
}
