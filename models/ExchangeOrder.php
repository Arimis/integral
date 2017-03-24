<?php

namespace arimis\integral\models;

use app\models\UserBase;
use arimis\integral\IntegralUserInterface;
use arimis\integral\rule\RulableTargetInterface;
use arimis\integral\rule\RuleInterface;
use Yii;

/**
 * This is the model class for table "exchange_order".
 *
 * @property integer $order_id
 * @property string $order_sn
 * @property integer $order_points_amount
 * @property double $order_cash_amount
 * @property integer $item_quantity
 * @property string $create_time
 * @property string $modify_time
 * @property string $user_code
 * @property integer $delivery_type
 * @property string $delivery_fee
 * @property string $consignee
 * @property string $province_name
 * @property string $city_name
 * @property string $direct_name
 * @property string $detail_address
 * @property string $order_status
 *
 * @property ExchangeOrderItem[] $exchangeOrderItems
 */
class ExchangeOrder extends \yii\db\ActiveRecord implements RulableTargetInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'exchange_order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_sn'], 'required'],
            [['order_points_amount', 'item_quantity', 'delivery_type'], 'integer'],
            [['order_cash_amount', 'delivery_fee'], 'number'],
            [['create_time', 'modify_time'], 'safe'],
            [['order_sn', 'user_code'], 'string', 'max' => 21],
            [['consignee', 'province_name', 'city_name', 'direct_name'], 'string', 'max' => 50],
            [['detail_address'], 'string', 'max' => 255],
            [['order_status'], 'string', 'max' => 4],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => Yii::t('arimis-integral', 'Order ID'),
            'order_sn' => Yii::t('arimis-integral', 'Order Sn'),
            'order_points_amount' => Yii::t('arimis-integral', 'Order Points Amount'),
            'order_cash_amount' => Yii::t('arimis-integral', 'Order Cash Amount'),
            'item_quantity' => Yii::t('arimis-integral', 'Item Quantity'),
            'create_time' => Yii::t('arimis-integral', 'Create Time'),
            'modify_time' => Yii::t('arimis-integral', 'Modify Time'),
            'user_code' => Yii::t('arimis-integral', 'User Code'),
            'delivery_type' => Yii::t('arimis-integral', '取货方式 1 到店自提 2 快递发货'),
            'delivery_fee' => Yii::t('arimis-integral', '快递费，当为快递发货的方式时使用'),
            'consignee' => Yii::t('arimis-integral', 'Consignee'),
            'province_name' => Yii::t('arimis-integral', 'Province Name'),
            'city_name' => Yii::t('arimis-integral', 'City Name'),
            'direct_name' => Yii::t('arimis-integral', 'Direct Name'),
            'detail_address' => Yii::t('arimis-integral', 'Detail Address'),
            'order_status' => Yii::t('arimis-integral', 'Order Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExchangeOrderItems()
    {
        return $this->hasMany(ExchangeOrderItem::className(), ['order_sn' => 'order_sn']);
    }

    /**
     * @inheritdoc
     * @return ExchangeOrderQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ExchangeOrderQuery(get_called_class());
    }

    /**
     * @return string 返回target对象的说明名称
     */
    public static function getTargetName()
    {
        return "积分兑换订单生成";
    }

    /**
     * 条件依赖的属性名称
     * @return string[]
     */
    public static function conditionColumnsMap()
    {
        return [];
    }

    /**
     * 获取获得积分的用户对象
     * @return IntegralUserInterface
     */
    public function getIntegralUser()
    {
        return UserBase::findOne(['user_code' => $this->user_code]);
    }

    /**
     * 返回该对象定义的所有状态及其说明的Map:
     * array(
     *  定义1 => 说明1,
     *  定义2 => 说明2,
     *  定义3 => 说明3
     * }
     * @return string[]
     */
    public static function getInvokeStatusMap()
    {
        return [];
    }

    /**
     * 通过单独的状态定义获取状态说明
     * @return string|false
     */
    public static function getInvokeStatusColumnName()
    {
        return false;
    }

    /**
     * 通过单独的状态定义获取状态说明
     * @return string|false
     */
    public static function getInvokeStatusColumnLabel()
    {
        return false;
    }

    /**
     * 如果此target会自己独立定义每次behavior发生时积分变化的规则，则返回TRUE，并正确实现 getDynamicChangeType(), getDynamicChangePoints()方法
     * @return boolean
     */
    public static function isDynamicPoints()
    {
        return true;
    }

    /**
     * 返回值只能是[
     * arimis\integral\rule\RuleInterface::INTEGRAL_CHANGE_TYPE_INCREASE,
     * arimis\integral\rule\RuleInterface::INTEGRAL_CHANGE_TYPE_REDUCE,
     * arimis\integral\rule\RuleInterface::INTEGRAL_CHANGE_TYPE_FROZE,
     * arimis\integral\rule\RuleInterface::INTEGRAL_CHANGE_TYPE_THAW
     * ]中的某一个
     * @return string
     */
    public function getDynamicChangeType()
    {
        return RuleInterface::INTEGRAL_CHANGE_TYPE_REDUCE;
    }

    /**
     * 动态返回变化的积分值
     * @return integer
     */
    public function getDynamicChangePoints()
    {
        return $this->order_points_amount;
    }

    /**
     * 用于积分日志排重
     * @return string
     */
    public function getUniqueKey()
    {
        return $this->order_sn;
    }
}
