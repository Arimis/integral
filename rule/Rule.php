<?php
/**
 * Created by Arimis Wang using eclipse neon on 2017年3月13日14:16:43
 * @author Arimis Wang
 * @package interpreter
 * @license 上海珂兰商贸有限公司
 * @link wangwengang@kela.cn
 */

namespace arimis\integral\rule;

use arimis\integral\IntegralScopeInterface;
use arimis\integral\models\IntegralRule;

class Rule extends IntegralRule implements RuleInterface {
	/**
	 * @var boolean
	 */
	protected $stackable = false;

    /**
     * @var RuleGroupInterface
     */
	protected $group = null;
	
	public function isStackable() {
		return $this->stackable && $this->getGroup()->isStackable();
	}
	
	public function setStackable($stackable) {
		$this->stackable = $stackable;
		return $this;
	}

    public function getScope()
    {
        return $this->scope;
    }

    public function setScope(IntegralScopeInterface $scope)
    {
        // TODO: Implement setScope() method.
    }

    /**
     * @param integer $weight
     * @return RuleInterface
     */
    public function setWeight($weight)
    {
        // TODO: Implement setWeight() method.
    }

    /**
     * @return integer
     */
    public function getWeight()
    {
        // TODO: Implement getWeight() method.
    }

    /**
     * @return RuleGroupInterface
     */
    public function getGroup()
    {
        // TODO: Implement getGroup() method.
    }

    /**
     * @param RuleGroupInterface $ruleGroup
     * @return RuleInterface
     */
    public function setGroup(RuleGroupInterface $ruleGroup)
    {
        // TODO: Implement setGroup() method.
    }

    /**
     * @return boolean
     */
    public function validateRule()
    {
        // TODO: Implement validateRule() method.
    }

}