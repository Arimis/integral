<?php

namespace arimis\integral\models;

/**
 * This is the ActiveQuery class for [[IntegralChange]].
 *
 * @see IntegralChange
 */
class IntegralChangeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return IntegralChange[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return IntegralChange|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
