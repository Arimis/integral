<?php

/**
 * Created by IntelliJ IDEA.
 * User: Arimis
 * Date: 2017/3/10
 * Time: 17:56
 */

namespace arimis\integral;


use yii\base\Arrayable;
use yii\db\ActiveRecordInterface;

interface IntegralUserInterface extends ActiveRecordInterface, \IteratorAggregate, \ArrayAccess, Arrayable
{
    /**
     * 通过此方法获取用户唯一标识字段名
     * @return string
     */
    public static function getUniqueIdentifyIDName();

    /**
     * 获取当前登陆的用户，自定义实现
     * @return IntegralUserInterface|boolean
     */
    public static function getCurrentActiveUser();

    /**
     * 通过此方法获取用户唯一标识字段的值
     * @return string
     */
    public function getUniqueIdentifyID();

    /**
     * 当操作成功时，返回IntegralUserInterface对象实例，否则返回false
     * @param integer $points
     * @return IntegralUserInterface|boolean
     */
    public function increase($points);

    /**
     * @param string $changeType
     * @param integer $points
     * @param IntegralScopeInterface $scope
     * @return boolean|string 如果验证通过，返回true；否则返回错误提示字符串
     */
    public function checkAuth($changeType, $points, IntegralScopeInterface $scope = null);

    /**
     * @param integer $point
     * @return IntegralUserInterface|boolean
     */
    public function reduce($point);

    /**
     * @param int $point
     * @return IntegralUserInterface|boolean
     */
    public function froze($point);

    /**
     * @param int $point
     * @return IntegralUserInterface|boolean
     */
    public function thaw($point);

    /**
     * @return integer
     */
    public function getTotal();

    /**
     * @return integer
     */
    public function getAvailable();

    /**
     * @return integer
     */
    public function getFrozen();

    /**
     * @return IntegralScopeInterface
     */
    public function getScope();

    /**
     * 获取登录地址
     * @return string
     */
    public static function getLoginUrl();
}