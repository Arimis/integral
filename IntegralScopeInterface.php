<?php
/**
 * Created by Arimis Wang using eclipse neon on 2017年3月13日14:16:43
 * @author Arimis Wang
 * @package interpreter
 * @license 上海珂兰商贸有限公司
 * @link wangwengang@kela.cn
 */

namespace arimis\integral;

use yii\web\IdentityInterface;

interface IntegralScopeInterface {

    /**
     * 获取管理者的scope
     * @param IdentityInterface $identity
     * @return IntegralScopeInterface[]
     */
    public static function getAuthorizedScope(IdentityInterface $identity);

    /**
     * 范围控制对象的属性标签
     * @return string
     */
	public static function getUniqueAttrLabel();

    /**
     * 范围控制的对象属性名称，如果是数据库，则为数据库字段名
     * @return string
     */
	public static function getUniqueAttrName();

    /**
     * 获取所有的scope
     * @return IntegralScopeInterface[]
     */
	public static function getAllScope();

    /**
     * 获取积分用户的scope
     * @param IntegralUserInterface $user
     * @return IntegralScopeInterface[]
     */
	public static function getIntegralUserScope(IntegralUserInterface $user);

    /**
     * 返回具体实例的范围值
     * @return string
     */
	public function getScopeName();

    /**
     * 返回具体实例的范围值
     * @return string
     */
    public function getScopeValue();
}