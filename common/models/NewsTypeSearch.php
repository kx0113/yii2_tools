<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\NewType;

/**
 * NewsTypeSearch represents the model behind the search form about `app\models\NewType`.
 */
class NewsTypeSearch extends NewType
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'add_user', 'create_at', 'token', 'sort'], 'integer'],
            [['name'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
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
    public function search($params)
    {
        $session=Yii::$app->session;

        $query = NewType::find()->where(['token'=>Yii::$app->session->get('web_id')]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'add_user' => $this->add_user,
            'create_at' => $this->create_at,
            'token' => $this->token,
            'sort' => $this->sort,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
