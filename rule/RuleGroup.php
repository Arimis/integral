<?php
/**
 * Created by Arimis Wang using eclipse neon on 2017年3月13日14:16:43
 * @author Arimis Wang
 * @package interpreter
 * @license 上海珂兰商贸有限公司
 * @link wangwengang@kela.cn
 */

namespace arimis\integral\rule;

class RuleGroup implements RuleGroupInterface {
	protected $groupName;
	protected $className;
	protected $stackable = true;
	
	public function getName()  {
		return  $this->groupName;
	}
	
	public function setClass($class) {
		$this->className = $class;
		return $this;
	}
	
	public function setStackable($stackable) {
		$this->stackable = $stackable;
		return $this;
	}
	
	public function isStackable() {
		return $this->stackable;
	}
	
	/**
	 * {@inheritDoc}
	 * @see \arimis\integral\RuleGroupIntergace::getRules()
	 */
	public function getRules() {
		return [];
	}
}