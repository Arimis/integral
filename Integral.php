<?php
/**
 * Created by Arimis Wang using eclipse neon on 2017年3月13日14:16:43
 * @author Arimis Wang
 * @package interpreter
 * @license 上海珂兰商贸有限公司
 * @link wangwengang@kela.cn
 */

namespace arimis\integral;

use arimis\integral\models\IntegralChange;
use arimis\integral\models\IntegralRule;
use arimis\integral\rule\RulableTargetInterface;
use arimis\integral\rule\Rule;
use arimis\integral\rule\RuleGroupInterface;
use arimis\integral\rule\RuleInterface;
use yii\base\Component;
use yii\base\Event;
use yii\db\ActiveRecord;
use yii\db\ActiveRecordInterface;
use yii\db\Exception;
use yii\web\NotFoundHttpException;

class Integral extends Component implements IntegralServiceInterface
{
	/**
	 * An array includes some full class name which instance of RulableTargetInterface
	 * @var string[]
	 */
	public $integralTargets = [];
	
	/**
	 * An array includes some full class name which instance of RuleGroupInterface
	 * @var string[]
     * @deprecated
	 */
	private $groups = [];
	
    /**
     * @var string
     */
	public $integralUserClass;

    /**
     * @var IntegralUserInterface $user
     */
	private $integralUser;

    /**
     * @var string IntegralScopeInterface的实现类
     */
	public $integralScopeClass;

	/**
	 * 是否开启积分商城的范围控制
	 * @var boolean
	 */
	public $openExchangeScopeCtrl = false;

    /**
     * 是否打开积分规则的范围控制
     * @var boolean
     */
    public $openRuleScopeCtrl = false;

	public function init() {
	    $this->validateInitConfig();

        /**
         * 绑定target的事件，只有设置了积分用户对象才会开始积分规则的加载
         */
        $this->initTargetSettings();
	}

    /**
     * 校验初始化设置
     */
	private function validateInitConfig()
    {
        /**
         * 检查是否配置
         */
        if(empty($this->integralUserClass)) {
            throw new \InvalidArgumentException("integralUserClass必须设置");
        }
        /**
         * 检查配置的类是否存在
         */
        if(!class_exists($this->integralUserClass)) {
            throw new NotFoundHttpException("找不到类：{$this->integralUserClass}");
        }
        /**
         * 检查配置的类是否实现了对应的接口
         */
        $integralUserInstance = new $this->integralUserClass();
        if(!$integralUserInstance instanceof IntegralUserInterface) {
            unset($integralUserInstance);
            throw new \InvalidArgumentException("类{$this->integralUserClass}必须实现接口 app\\services\\integral\\IntegralUserInterface");
        }
        if(!$integralUserInstance instanceof ActiveRecord) {
            unset($integralUserInstance);
            throw new \InvalidArgumentException("类{$this->integralUserClass}必须继承 yii\\db\\ActiveRecord");
        }
        unset($integralUserInstance);


        if(is_string($this->integralTargets)) {
            $this->integralTargets = [$this->integralTargets];
        }
        if(empty($this->integralTargets) || (is_array($this->integralTargets) && count($this->integralTargets) == 0)) {
            throw new \InvalidArgumentException("integralTargets必须设置");
        }
        foreach ($this->integralTargets as $targetClass) {
            if(!class_exists($targetClass)) {
                throw new NotFoundHttpException("找不到类：{$targetClass}");
            }
            $integralTargetInstance = new $targetClass();
            if(!$integralTargetInstance instanceof RulableTargetInterface) {
                unset($integralTargetInstance);
                throw new \InvalidArgumentException("类{$targetClass}必须实现接口 app\\services\\integral\\rule\\RulableTargetInterface");
            }
            if(!$integralTargetInstance instanceof ActiveRecord) {
                unset($integralUserInstance);
                throw new \InvalidArgumentException("类{$targetClass}必须继承 yii\\db\\ActiveRecord");
            }
            unset($integralTargetInstance);
        }


        if(!empty($this->integralScopeClass)) {
            if (!class_exists($this->integralScopeClass)) {
                throw new NotFoundHttpException("找不到类：{$this->integralScopeClass}");
            }

            $integralScopeInstance = new $this->integralScopeClass();
            if(!$integralScopeInstance instanceof IntegralScopeInterface) {
                unset($integralScopeInstance);
                throw new \InvalidArgumentException("类{$this->integralScopeClass}必须实现接口 app\\services\\integral\\IntegralScopeInterface");
            }

            if(!$integralScopeInstance instanceof ActiveRecord) {
                unset($integralScopeInstance);
                throw new \InvalidArgumentException("类{$this->integralScopeClass}必须继承 yii\\db\\ActiveRecord");
            }
            unset($integralScopeInstance);
        }

    }

    /**
     * @param RulableTargetInterface[] $targets
     * @return mixed
     */
    public function setIntegralTargets(array $targets)
    {
        $this->integralTargets = $targets;
    }

    private function initTargetSettings() {
        /**
         * 绑定target的事件，只有设置了积分用户对象才会开始积分规则的加载
         */
        if(count($this->integralTargets) > 0) {
            foreach ($this->integralTargets as $targetClass) {
                if($targetClass::getInvokeStatusColumnName()) {
                    $eventName = ActiveRecord::EVENT_AFTER_UPDATE;
                }
                else {
                    $eventName = ActiveRecord::EVENT_AFTER_INSERT;
                }

                Event::on($targetClass, $eventName, function($event) {
                    /**
                     * @var Event $event
                     */
                    static::runIntegralRule($event->sender);

                });

            }
        }
    }

    public static function  initI18nConfig()
    {
        if (!isset(\Yii::$app->i18n->translations['arimis-integral'])) {
            \Yii::$app->i18n->translations['arimis-integral'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en',
                'basePath' => '@app/services/integral/messages'
            ];
        }
    }

    /**
     * @param IntegralUserInterface $user
     * @param RulableTargetInterface $target
     * @return RuleInterface[]
     */
    public function getRulesByUserAndTarget(IntegralUserInterface $user, RulableTargetInterface $target)
    {
        $scope = null;
        if(!empty($user->getScope())) {
            $scope = $user->getScope()->getScopeValue();
        }
        $rules = $this->getRulesByTargetClassName($target::className(), $scope);
        return $rules;
    }

    /**
     * @param string $target
     * @param string $scope
     * @return IntegralRule[]
     */
    public static function getRulesByTargetClassName($target, $scope = null)
    {
        return Rule::findAll(['target_class_name' => $target, 'scope' => $scope]);
    }

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
    public static function changeIntegral(IntegralUserInterface $userBase, $ruleCode, $targetUniqueKey, $changeType, $changePoints, $changeDesc, array $params)
    {
        $changeLog = new IntegralChange();
        if($msg = $userBase->checkAuth($changeType, $changePoints, $userBase->getScope()) === true) {
            $changeLog->addError("auth", $msg);
        }
        else {
            $transaction = \Yii::$app->getDb()->beginTransaction();
            try {
                $pointsAvailableBefore = $userBase->getAvailable();
                $pointsFrozenBefore = $userBase->getFrozen();
                /**
                 * 1 变更用户的积分
                 */
                $rs = null;
                switch ($changeType) {
                    case RuleInterface::INTEGRAL_CHANGE_TYPE_INCREASE: {
                        $rs =$userBase->increase($changePoints);
                        break;
                    }
                    case RuleInterface::INTEGRAL_CHANGE_TYPE_REDUCE: {
                        $rs =$userBase->reduce($changePoints);
                        break;
                    }
                    case RuleInterface::INTEGRAL_CHANGE_TYPE_FROZE: {
                        $rs =$userBase->froze($changePoints);
                        break;
                    }
                    case RuleInterface::INTEGRAL_CHANGE_TYPE_THAW: {
                        $rs =$userBase->thaw($changePoints);
                        break;
                    }
                    default: {
                        return false;
                    }
                }
                if($rs === false) {
                    throw new Exception(json_encode($userBase->getErrors()));
                }

                $pointsAvailableAfter = $userBase->getAvailable();
                $pointsFrozenAfter = $userBase->getFrozen();

                /**
                 * 2 增加积分变更日志
                 */
                $changeLog->user_code = $userBase->getUniqueIdentifyID();
                $changeLog->rule_code = $ruleCode;
                $changeLog->target_unique_key = strtoupper(md5($targetUniqueKey));
                $changeLog->change_desc = $changeDesc;
                $changeLog->change_type = $changeType;
                $changeLog->change_points = $changePoints;
                $changeLog->before_available = $pointsAvailableBefore;
                $changeLog->before_frozen = $pointsFrozenBefore;
                $changeLog->after_available = $pointsAvailableAfter;
                $changeLog->after_frozen = $pointsFrozenAfter;
                $changeLog->params = is_string($params) ? $params : json_encode($params);
                $changeLog->create_time = date("Y-m-d H:i:s");
                $changeLog->modify_time = date("Y-m-d H:i:s");
                $changeLog->create_admin = "integral-api";
                if(!$changeLog->save()) {
                    \Yii::error('integral change log save failed: ' . json_encode($changeLog->getErrors()));
                    throw new Exception(json_encode($changeLog->getErrors()));
                }
                $transaction->commit();

            } catch (Exception $e) {
                $transaction->rollBack();
                $changeLog->addError('db', $e->getMessage());
            }
        }
        return $changeLog;
    }

    /**
     * @return IntegralUserInterface|boolean
     * @throws \yii\base\Exception
     */
    public function getIntegralUser()
    {
        if(empty($this->user)) {
            if(class_exists($this->integralUserClass)) {
                $classRef = new \ReflectionClass($this->integralUserClass);
                $implementInterfaces = $classRef->getInterfaceNames();
                $extendClass = $classRef->getParentClass();
                $integralUserInterfaceName = IntegralUserInterface::class;
                if(!in_array($integralUserInterfaceName, $implementInterfaces)) {
                    throw new \yii\base\Exception("用户基类必须实现{$integralUserInterfaceName}接口");
                }
                $activeRecordName = ActiveRecord::className();
                if($extendClass->getName() != $activeRecordName) {
                    throw new \yii\base\Exception("用户基类必须继承自{$activeRecordName}类");
                }
                $methodRef = $classRef->getMethod("getCurrentActiveUser");
                $this->integralUser = $methodRef->invoke(new $this->integralUserClass());
            }
        }
        return $this->integralUser;
    }

    /**
     * @param IntegralUserInterface $user
     * @return mixed
     */
    public function setIntegralUser(IntegralUserInterface $user)
    {
        $this->integralUser = $user;
    }

    /**
     * @return string
     */
    public function getIntegralUserSetting()
    {
        return $this->integralUserClass;
    }

    /**
     * 返回配置的targets数组
     * @return string[]
     */
    public function getIntegralTargetSettings()
    {
        return $this->integralTargets;
    }

    /**
     * @param IntegralUserInterface $user
     * @param IntegralScopeInterface $scope
     * @param $timeStart
     * @param $timeEnd
     * @param $start
     * @param $offset
     * @return IntegralChange[]
     */
    public function loadUserIntegralChanges(IntegralUserInterface $user, IntegralScopeInterface $scope = null, $timeStart, $timeEnd, $start, $offset)
    {
        return [];
    }

    /**
     * @return string
     */
    public function getintegralScopeSetting()
    {
        return $this->integralScopeClass;
    }

    /**
     * 是否打开积分商城的范围控制
     * @return boolean
     */
    public function isOpenExchangeScopeCtrl()
    {
        return $this->openExchangeScopeCtrl;
    }

    /**
     * 是否打开积分规则的范围控制
     * @return boolean
     */
    public function isOpenRuleScopeCtrl()
    {
        return $this->openRuleScopeCtrl;
    }

    public static function runIntegralRule(RulableTargetInterface $target)
    {
        $integralUser = $target->getIntegralUser();
        if(!$integralUser instanceof IntegralUserInterface) {
            return false;
        }
        $scope = $integralUser->getScope();
        if($scope instanceof IntegralScopeInterface) {
            $scope = $scope->getScopeName();
        }
        else {
            $scope  = null;
        }
        $targetRules = static::getRulesByTargetClassName($target::className(), $scope);
        if(empty($targetRules)) {
            return false;
        }
        /**
         * @var Rule[] $validRules
         */
        $validRules = [];
        /**
         * 校验规则：过滤不合规的规则
         */
        foreach ($targetRules as $rule) {
            /**
             * step 0: 是否开启 is_active
             */
            if(!$rule->is_active) {
                continue;
            }
            /**
             * step 1: 检查是否是在过滤字段
             */
            $conditionColumn = $rule->condition_column;
            $conditionType = strtoupper($rule->condition_type);
            $conditionValueRange = $rule->condition_value_range;
            if($conditionColumn && $conditionValueRange) {
                $targetConditionValue = trim($target->{$conditionColumn});
                switch($conditionType) {
                    case RuleInterface::RANGE_TYPE_BETWEEN: {
                        $conditionValueRange = explode(",", $conditionValueRange);
                        if(count($conditionValueRange) < 2) {
                            continue;
                        }

                        if(!($targetConditionValue >= $conditionValueRange[0] && $targetConditionValue <= $conditionValueRange[1])) {
                            continue;
                        }
                        break;
                    }
                    case RuleInterface::RANGE_TYPE_IN: {
                        $conditionValueRange = explode(",", $conditionValueRange);
                        if (count($conditionValueRange) < 1) {
                            continue;
                        }
                        if (!in_array($targetConditionValue, $conditionValueRange)) {
                            continue;
                        }
                        break;
                    }
                    case RuleInterface::RANGE_TYPE_LESS_THAN:{
                        if(!is_numeric($conditionValueRange)) {
                            continue;
                        }

                        if($targetConditionValue >= $conditionValueRange) {
                            continue;
                        }
                        break;
                    }
                    case RuleInterface::RANGE_TYPE_LESS_THAN_AND_EQUALS:{
                        if(!is_numeric($conditionValueRange)) {
                            continue;
                        }

                        if($targetConditionValue > $conditionValueRange) {
                            continue;
                        }
                        break;
                    }
                    case RuleInterface::RANGE_TYPE_GREAT_THAN:{
                        if(!is_numeric($conditionValueRange)) {
                            continue;
                        }

                        if($targetConditionValue <= $conditionValueRange) {
                            continue;
                        }
                        break;
                    }
                    case RuleInterface::RANGE_TYPE_GREAT_THAN_AND_EQUALS:{
                        if(!is_numeric($conditionValueRange)) {
                            continue;
                        }

                        if($targetConditionValue < $conditionValueRange) {
                            continue;
                        }
                        break;
                    }
                }
            }

            /**
             * step 2: 检查是否设置了状态值
             */
            $invokeStatusColumn = trim($rule->invoke_status_column);
            $invokeStatusValueBefore = trim($rule->invoke_status_value_before);
            $invokeStatusValueTarget = trim($rule->invoke_status_value_target);
            if($invokeStatusColumn && $invokeStatusValueBefore && $invokeStatusValueTarget) {
                /**
                 * @var ActiveRecord $target
                 */
                $targetOldStatus = $target->getOldAttribute($invokeStatusColumn);
                $targetNewStatus = $target->getAttribute($invokeStatusColumn);
                if(!($targetOldStatus == $invokeStatusValueBefore && $targetNewStatus == $invokeStatusValueTarget)) {
                    continue;
                }
            }

            /**
             * step 3: 校验执行频率
             */
            $changeFrequencyType = $rule->change_frequency_type;
            $changeLog = IntegralChange::find()->andFilterWhere([
                'rule_code' => $rule->rule_code,
                'user_code' => $integralUser->getUniqueIdentifyID(),
                'target_unique_key' => strtolower(md5($target->getUniqueKey()))
            ])->orderBy("create_time DESC")->one();

            if($changeLog) {
                /**
                 * 周期性执行
                 */
                if ($changeFrequencyType==RuleInterface::CHANGE_FREQUENCY_TYPE_REGULARLY) {
                    switch ($changeFrequencyType) {
                        case RuleInterface::CHANGE_FREQUENCY_VAL_EVERY_DAY: {
                            $thisDay = date("d");
                            $logDay = date("d", strtotime($changeLog->create_time));
                            if($thisDay == $logDay) {
                                continue;
                            }
                            break;
                        }
                        case RuleInterface::CHANGE_FREQUENCY_VAL_EVERY_WEEK: {
                            $thisWeek = date("W");
                            $logWeek = date("W", strtotime($changeLog->create_time));
                            if($thisWeek == $logWeek) {
                                continue;
                            }
                            break;
                        }
                        case RuleInterface::CHANGE_FREQUENCY_VAL_EVERY_MONTH: {
                            $thisMonth = date("m");
                            $logMonth = date("m", strtotime($changeLog->create_time));
                            if($thisMonth == $logMonth) {
                                continue;
                            }
                            break;
                        }
                        case RuleInterface::CHANGE_FREQUENCY_VAL_EVERY_SEASON: {
                            $thisMonth = date("M");
                            $logMonth = date("M", strtotime($changeLog->create_time));
                            if(floor($thisMonth / 3) == floor($logMonth / 3)) {
                                continue;
                            }
                            break;
                        }
                        case RuleInterface::CHANGE_FREQUENCY_VAL_EVERY_YEAR: {
                            $thisYear = date("Y");
                            $logYear = date("Y", strtotime($changeLog->create_time));
                            if($thisYear == $logYear) {
                                continue;
                            }
                            break;
                        }

                    }
                } /**
                 * 只执行一次
                 */
                else if ($changeFrequencyType==RuleInterface::CHANGE_FREQUENCY_TYPE_ONLY_ONCE) {
                    continue;
                }
            }

            /**
             * step 4: 判断是否设置有效时间范围并且当前时间节点是否在有效期范围内
             */
            $today = date("Y-m-d H:i:s");
            if($rule->time_start && $today < $rule->time_start) {
                continue;
            }
            if($rule->time_end && $today > $rule->time_end) {
                continue;
            }


            /**
             * step 5: 确定积分变更信息：变更方式和变更值
             * @var RulableTargetInterface $target
             */
            if($target::isDynamicPoints()) {
                $rule->change_type = $target->getDynamicChangeType();
                $rule->change_points = $target->getDynamicChangePoints();
            }

            $validRules[] = $rule;
        }

        /**
         * 比较规则优先级：是否允许叠加使用 AND 权重大小
         */

        $isStackable = true;
        array_map(function($rule) use ($target, &$isStackable) {
            /**
             * @var IntegralRule $rule
             */
            if(!$rule->stackable) {
                $isStackable = false;
            }
        }, $validRules);
        if(!$isStackable) {
            $finalRule = current($validRules);
            foreach ($validRules as $key => $rule) {
                if($rule->weight > $finalRule->weight) {
                    $finalRule = $rule;
                }
            }
            $validRules = [$finalRule];
        }

        /**
         * 执行积分变更
         */

        foreach ($validRules as $rule) {
            $result = static::changeIntegral($target->getIntegralUser(), $rule->rule_code, $target->getUniqueKey(), $rule->change_type, $rule->change_points, $target::getTargetName(), ['old' => $target->getOldAttributes(), 'new' => $target->getAttributes()]);
            $error = $result->getFirstErrors();
            if($error) {
                throw new \yii\base\Exception(json_encode($error));
            }
        }
    }
}