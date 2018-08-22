<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Order;

/**
 * OrderSearch represents the model behind the search form about `app\models\Order`.
 */
class OrderSearch extends Order
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'is_invoice', 'invoice_type'], 'integer'],
            [['name', 'content_name', 'content_phone', 'email', 'invoice_title', 'invoice_address', 'invoice_name', 'invoice_phone', 'check_in_time', 'check_out_time', 'total_price', 'hotel_id', 'room_id', 'create_time'], 'safe'],
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
        $query = Order::find();

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
            'is_invoice' => $this->is_invoice,
            'invoice_type' => $this->invoice_type,
            'check_in_time' => $this->check_in_time,
            'check_out_time' => $this->check_out_time,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'content_name', $this->content_name])
            ->andFilterWhere(['like', 'content_phone', $this->content_phone])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'invoice_title', $this->invoice_title])
            ->andFilterWhere(['like', 'invoice_address', $this->invoice_address])
            ->andFilterWhere(['like', 'invoice_name', $this->invoice_name])
            ->andFilterWhere(['like', 'invoice_phone', $this->invoice_phone])
            ->andFilterWhere(['like', 'total_price', $this->total_price])
            ->andFilterWhere(['like', 'hotel_id', $this->hotel_id])
            ->andFilterWhere(['like', 'room_id', $this->room_id]);

        return $dataProvider;
    }
}
