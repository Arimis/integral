<?php

/**
 * Created by IntelliJ IDEA.
 * User: Arimis
 * Date: 2017/3/10
 * Time: 18:22
 */

namespace arimis\integral\rule;


use arimis\integral\IntegralUserInterface;
use yii\db\ActiveRecordInterface;

interface RulableTargetInterface extends ActiveRecordInterface
{
    /**
     * 返回该类的全路径限定名
     * @return string
     */
	public static function className();

    /**
     * @return string 返回target对象的说明名称
     */
	public static function getTargetName();
	
	/**
	 * 条件依赖的属性名称
	 * @return string[]
	 */
	public static function conditionColumnsMap();

	/**
	 * 获取获得积分的用户对象
     * @return IntegralUserInterface
	 */
	public function getIntegralUser();
	
    /**
     * 返回该对象定义的所有状态及其说明的Map:
     * array(
     *  定义1 => 说明1,
     *  定义2 => 说明2,
     *  定义3 => 说明3
     * }
     * @return string[]
     */
	public static function getInvokeStatusMap();

    /**
     * 通过单独的状态定义获取状态说明
     * @return string|false
     */
	public static function getInvokeStatusColumnName();

    /**
     * 通过单独的状态定义获取状态说明
     * @return string|false
     */
    public static function getInvokeStatusColumnLabel();

    /**
     * 返回值为[
     * arimis\integral\rule\RuleInterface::STORAGE_STATUS_CREATED,
     * arimis\integral\rule\RuleInterface::STORAGE_STATUS_UPDATED
     * ]其中之一
     * @deprecated 此方法不需要了
     * @return string created or updated
     */
    //public static function getStorageStatus();

    /**
     * 如果此target会自己独立定义每次behavior发生时积分变化的规则，则返回TRUE，并正确实现 getDynamicChangeType(), getDynamicChangePoints()方法
     * @return boolean
     */
    public static function isDynamicPoints();

    /**
     * 返回值只能是[
     * arimis\integral\rule\RuleInterface::INTEGRAL_CHANGE_TYPE_INCREASE,
     * arimis\integral\rule\RuleInterface::INTEGRAL_CHANGE_TYPE_REDUCE,
     * arimis\integral\rule\RuleInterface::INTEGRAL_CHANGE_TYPE_FROZE,
     * arimis\integral\rule\RuleInterface::INTEGRAL_CHANGE_TYPE_THAW
     * ]中的某一个
     * @return string
     */
	public function getDynamicChangeType();

    /**
     * 动态返回变化的积分值
     * @return integer
     */
	public function getDynamicChangePoints();

    /**
     * 用于积分日志排重
     * @return string
     */
	public function getUniqueKey();
}