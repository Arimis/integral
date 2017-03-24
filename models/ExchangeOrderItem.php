<?php

namespace arimis\integral\models;

use Yii;

/**
 * This is the model class for table "exchange_order_item".
 *
 * @property integer $item_id
 * @property string $user_code
 * @property string $item_name
 * @property string $item_code
 * @property string $item_cost
 * @property string $item_price
 * @property integer $item_points
 * @property string $total_cost
 * @property string $total_amount
 * @property integer $total_points
 * @property string $order_sn
 * @property string $list_picture
 * @property integer $quantity
 *
 * @property ExchangeOrder $orderSn
 * @property IntegralGift $itemCode
 */
class ExchangeOrderItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'exchange_order_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_cost', 'item_price', 'total_cost', 'total_amount'], 'number'],
            [['item_points', 'total_points', 'quantity'], 'integer'],
            [['user_code', 'order_sn'], 'string', 'max' => 21],
            [['item_name', 'list_picture'], 'string', 'max' => 255],
            [['item_code'], 'string', 'max' => 50],
            [['order_sn'], 'exist', 'skipOnError' => true, 'targetClass' => ExchangeOrder::className(), 'targetAttribute' => ['order_sn' => 'order_sn']],
            [['item_code'], 'exist', 'skipOnError' => true, 'targetClass' => IntegralGift::className(), 'targetAttribute' => ['item_code' => 'gift_code']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'item_id' => Yii::t('arimis-integral', 'Item ID'),
            'user_code' => Yii::t('arimis-integral', '用户编码'),
            'item_name' => Yii::t('arimis-integral', '项目名称'),
            'item_code' => Yii::t('arimis-integral', '项目唯一标识'),
            'item_cost' => Yii::t('arimis-integral', '单个成本'),
            'item_price' => Yii::t('arimis-integral', '单个标签价'),
            'item_points' => Yii::t('arimis-integral', '单个积分'),
            'total_cost' => Yii::t('arimis-integral', '总成本'),
            'total_amount' => Yii::t('arimis-integral', '总标签价'),
            'total_points' => Yii::t('arimis-integral', '总积分'),
            'order_sn' => Yii::t('arimis-integral', '订单编号'),
            'list_picture' => Yii::t('arimis-integral', '列表图片'),
            'quantity' => Yii::t('arimis-integral', '数量'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderSn()
    {
        return $this->hasOne(ExchangeOrder::className(), ['order_sn' => 'order_sn']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemCode()
    {
        return $this->hasOne(IntegralGift::className(), ['gift_code' => 'item_code']);
    }
}
