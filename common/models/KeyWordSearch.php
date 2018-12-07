<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\KeyWord;

/**
 * KeyWordSearch represents the model behind the search form about `app\models\KeyWord`.
 */
class KeyWordSearch extends KeyWord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'token', 'add_time', 'update_time', 'add_user'], 'integer'],
            [['title'], 'safe'],
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

        $query = KeyWord::find()->where(['token'=>Yii::$app->session->get('web_id')]);
//        $query = KeyWord::find();

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
            'token' => $this->token,
            'add_time' => $this->add_time,
            'update_time' => $this->update_time,
            'add_user' => $this->add_user,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
