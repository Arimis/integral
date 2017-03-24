<?php

namespace arimis\integral\models;

use Yii;

/**
 * This is the model class for table "integral_gift".
 *
 * @property integer $gift_id
 * @property string $gift_code
 * @property string $gift_name
 * @property string $scope
 * @property string $gift_list_pic
 * @property integer $gift_points
 * @property integer $gift_quantity
 * @property string $gift_cost
 * @property string $gift_purchase_price
 * @property string $gift_desc
 * @property integer $is_onsale
 * @property integer $sort
 * @property string $create_time
 * @property string $modify_time
 * @property string $create_admin
 *
 * @property ExchangeOrderItem[] $exchangeOrderItems
 */
class IntegralGift extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'integral_gift';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gift_points', 'gift_quantity', 'is_onsale', 'sort'], 'integer'],
            [['gift_cost', 'gift_purchase_price'], 'number'],
            [['gift_desc'], 'string'],
            [['create_time', 'modify_time'], 'safe'],
            [['gift_code', 'create_admin', 'scope'], 'string', 'max' => 20],
            [['gift_name', 'gift_list_pic'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gift_id' => Yii::t('arimis-integral', 'Gift ID'),
            'gift_code' => Yii::t('arimis-integral', '礼品编号，系统生成'),
            'gift_name' => Yii::t('arimis-integral', '名称'),
            'scope' => Yii::t('arimis-integral', '适用范围'),
            'gift_list_pic' => Yii::t('arimis-integral', '列表的图片'),
            'gift_points' => Yii::t('arimis-integral', '兑换所需积分'),
            'gift_quantity' => Yii::t('arimis-integral', '-1-表示没有数量限制，其他>=0的数字表示可兑换的数量'),
            'gift_cost' => Yii::t('arimis-integral', '礼品的成品价，用户展示给用户'),
            'gift_purchase_price' => Yii::t('arimis-integral', '礼品实际采购的价格'),
            'gift_desc' => Yii::t('arimis-integral', '图文描述'),
            'is_onsale' => Yii::t('arimis-integral', '是否上架'),
            'sort' => Yii::t('arimis-integral', '排序'),
            'create_time' => Yii::t('arimis-integral', 'Create Time'),
            'modify_time' => Yii::t('arimis-integral', 'Modify Time'),
            'create_admin' => Yii::t('arimis-integral', 'Create Admin'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExchangeOrderItems()
    {
        return $this->hasMany(ExchangeOrderItem::className(), ['item_code' => 'gift_code']);
    }
}
