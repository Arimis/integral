<?php

namespace arimis\integral\models;

/**
 * This is the ActiveQuery class for [[IntegralRule]].
 *
 * @see IntegralRule
 */
class IntegralRuleQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return IntegralRule[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return IntegralRule|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
