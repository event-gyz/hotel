<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Bed;

/**
 * BedSearch represents the model behind the search form about `app\models\Bed`.
 */
class BedSearch extends Bed
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'breakfast'], 'integer'],
            [['name','bed_name', 'price', 'create_time'], 'safe'],
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
        $query = Bed::find();

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
            'breakfast' => $this->breakfast,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'bed_name', $this->bed_name])
            ->andFilterWhere(['like', 'price', $this->price]);

        return $dataProvider;
    }
}
