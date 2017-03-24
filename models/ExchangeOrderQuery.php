<?php

namespace arimis\integral\models;

/**
 * This is the ActiveQuery class for [[ExchangeOrder]].
 *
 * @see ExchangeOrder
 */
class ExchangeOrderQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ExchangeOrder[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ExchangeOrder|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
