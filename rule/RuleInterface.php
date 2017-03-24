<?php

/**
 * Created by IntelliJ IDEA.
 * User: Arimis
 * Date: 2017/3/10
 * Time: 18:07
 */

namespace arimis\integral\rule;


use arimis\integral\IntegralScopeInterface;
use yii\db\ActiveRecordInterface;

interface RuleInterface extends ActiveRecordInterface
{
    const INTEGRAL_CHANGE_TYPE_INCREASE = 'increase';
    const INTEGRAL_CHANGE_TYPE_REDUCE = 'reduce';
    const INTEGRAL_CHANGE_TYPE_FROZE = 'froze';
    const INTEGRAL_CHANGE_TYPE_THAW = 'thaw';

    const RANGE_TYPE_EQUALS = '=';
    const RANGE_TYPE_GREAT_THAN = '>';
    const RANGE_TYPE_LESS_THAN = '<';
    const RANGE_TYPE_GREAT_THAN_AND_EQUALS = '>=';
    const RANGE_TYPE_LESS_THAN_AND_EQUALS = '<=';
    const RANGE_TYPE_BETWEEN = 'BETWEEN';
    const RANGE_TYPE_IN = 'IN';

    const DATA_STORAGE_STATUS_CREATED = 'CREATED';
    const DATA_STORAGE_STATUS_UPDATED = 'UPDATED';

    const CHANGE_FREQUENCY_TYPE_ONLY_ONCE = '1';
    const CHANGE_FREQUENCY_TYPE_EVERY_TIME = '2';
    const CHANGE_FREQUENCY_TYPE_REGULARLY = '3';

    const CHANGE_FREQUENCY_VAL_EVERY_DAY = '1';
    const CHANGE_FREQUENCY_VAL_EVERY_WEEK = '2';
    const CHANGE_FREQUENCY_VAL_EVERY_MONTH = '3';
    const CHANGE_FREQUENCY_VAL_EVERY_SEASON = '4';
    const CHANGE_FREQUENCY_VAL_EVERY_YEAR = '5';

    /**
     * @return IntegralScopeInterface
     */
	public function getScope();

    /**
     * @param IntegralScopeInterface $scope
     * @return mixed
     */
	public function setScope(IntegralScopeInterface $scope);

    /**
     * @param boolean $stackable
     * @return RuleInterface
     */
    public function setStackable($stackable);

    /**
     * @return boolean
     */
    public function isStackable();

    /**
     * @param integer $weight
     * @return RuleInterface
     */
    public function setWeight($weight);

    /**
     * @return integer
     */
    public function getWeight();
    
    /**
     * @return RuleGroupInterface
     */
    public function getGroup();
    
    /**
     * @param RuleGroupInterface $ruleGroup
     * @return RuleInterface
     */
    public function setGroup(RuleGroupInterface $ruleGroup);

    /**
     * @return boolean
     */
    public function validateRule();
}