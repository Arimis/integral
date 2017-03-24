<?php

namespace arimis\integral\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use arimis\integral\models\IntegralRule;

/**
 * IntegralRuleSearch represents the model behind the search form about `arimis\integral\models\IntegralRule`.
 */
class IntegralRuleSearch extends IntegralRule
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rule_id', 'is_active', 'is_dynamic_point', 'weight', 'stackable', 'change_points', 'change_frequency_type', 'change_frequency_value'], 'integer'],
            [['rule_code', 'rule_name', 'rule_desc', 'target_class_name', 'scope', 'condition_column', 'condition_type', 'condition_value_range', 'group', 'change_type', 'invoke_status_column', 'invoke_status_value_before', 'invoke_status_value_target', 'create_time', 'modify_time', 'create_admin'], 'safe'],
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
        $query = IntegralRule::find();

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
            'rule_id' => $this->rule_id,
            'is_active' => $this->is_active,
            'is_dynamic_point' => $this->is_dynamic_point,
            'weight' => $this->weight,
            'stackable' => $this->stackable,
            'change_points' => $this->change_points,
            'change_frequency_type' => $this->change_frequency_type,
            'change_frequency_value' => $this->change_frequency_value,
            'create_time' => $this->create_time,
            'modify_time' => $this->modify_time,
        ]);

        $query->andFilterWhere(['like', 'rule_name', $this->rule_name])
            ->andFilterWhere(['like', 'rule_code', $this->rule_code])
            ->andFilterWhere(['like', 'rule_desc', $this->rule_desc])
            ->andFilterWhere(['like', 'target_class_name', $this->target_class_name])
            ->andFilterWhere(['like', 'scope', $this->scope])
            ->andFilterWhere(['like', 'condition_column', $this->condition_column])
            ->andFilterWhere(['like', 'condition_type', $this->condition_type])
            ->andFilterWhere(['like', 'condition_value_range', $this->condition_value_range])
            ->andFilterWhere(['like', 'group', $this->group])
            ->andFilterWhere(['like', 'change_type', $this->change_type])
            ->andFilterWhere(['like', 'invoke_status_column', $this->invoke_status_column])
            ->andFilterWhere(['like', 'invoke_status_value_before', $this->invoke_status_value_before])
            ->andFilterWhere(['like', 'invoke_status_value_target', $this->invoke_status_value_target])
            ->andFilterWhere(['like', 'create_admin', $this->create_admin]);

        return $dataProvider;
    }
}
