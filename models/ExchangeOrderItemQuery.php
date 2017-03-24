<?php

namespace arimis\integral\models;

/**
 * This is the ActiveQuery class for [[ExchangeOrderItem]].
 *
 * @see ExchangeOrderItem
 */
class ExchangeOrderItemQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ExchangeOrderItem[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ExchangeOrderItem|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
