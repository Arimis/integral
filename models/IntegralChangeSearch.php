<?php

namespace arimis\integral\models;

use Yii;
use yii\data\ActiveDataProvider;

class IntegralChangeSearch extends IntegralChange
{
    public function search(array $params) {
        $query = IntegralChange::find();
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
            'user_code' => $this->user_code,
            'create_time' => $this->create_time
        ]);

        $query->limit(10);
        $page = isset($params['page']) ? $params['page'] : 1;
        if(empty($page) || !is_numeric($page) || $page <= 0) {
            $page = 1;
        }
        $query->offset(($page - 1) * $query->limit);
        $query->orderBy("create_time desc");

        return $dataProvider;
    }
}
