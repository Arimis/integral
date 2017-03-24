<?php
/**
 * Created by IntelliJ IDEA.
 * User: Arimis
 * Date: 2017/3/10
 * Time: 18:35
 */

namespace arimis\integral;


use arimis\integral\models\IntegralChange;
use arimis\integral\models\IntegralRule;
use arimis\integral\rule\RulableTargetInterface;
use arimis\integral\rule\RuleInterface;

interface IntegralServiceInterface
{
    /**
     * @param IntegralUserInterface $user
     * @return mixed
     */
    public function setIntegralUser(IntegralUserInterface $user);

    /**
     * @return IntegralUserInterface|boolean
     */
    public function getIntegralUser();

    /**
     * @return string
     */
    public function getIntegralUserSetting();

    /**
     * 初始化多语言设置
     * @return mixed
     */
    public static function initI18nConfig();

    /**
     * @param RulableTargetInterface[] $targets
     * @return mixed
     */
    public function setIntegralTargets(array $targets);

    /**
     * @param string $target
     * @param string $scope
     * @return IntegralRule[]
     */
    public static function getRulesByTargetClassName($target, $scope = null);

    /**
     * @param IntegralUserInterface $user
     * @param RulableTargetInterface $target
     * @return RuleInterface[]
     */
    public function getRulesByUserAndTarget(IntegralUserInterface $user, RulableTargetInterface $target);

    /**
     * 返回配置的targets数组
     * @return string[]
     */
    public function getIntegralTargetSettings();

    /**
     * @param IntegralUserInterface $user
     * @param IntegralScopeInterface $scope
     * @param $timeStart
     * @param $timeEnd
     * @param $start
     * @param $offset
     * @return IntegralChange[]
     */
    public function loadUserIntegralChanges(IntegralUserInterface $user, IntegralScopeInterface $scope = null, $timeStart, $timeEnd, $start, $offset);

    /**
     * @param IntegralUserInterface $userBase
     * @param string $ruleCode
     * @param string $targetUniqueKey
     * @param string $changeType
     * @param integer $changePoints
     * @param string $changeDesc
     * @param array $params
     * @return IntegralChange
     */
    public static function changeIntegral(IntegralUserInterface $userBase, $ruleCode, $targetUniqueKey, $changeType, $changePoints, $changeDesc, array $params);

    /**
     * @return string
     */
    public function getIntegralScopeSetting();

    /**
     * 是否打开积分商城的范围控制
     * @return boolean
     */
    public function isOpenExchangeScopeCtrl();

    /**
     * 是否打开积分规则的范围控制
     * @return boolean
     */
    public function isOpenRuleScopeCtrl();

    public static function runIntegralRule(RulableTargetInterface $target);
}