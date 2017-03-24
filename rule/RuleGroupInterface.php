<?php
/**
 * Created by Arimis Wang using eclipse neon on 2017年3月13日14:16:43
 * @author Arimis Wang
 * @package arimis\integral
 * @license 上海珂兰商贸有限公司
 * @link wangwengang@kela.cn
 */

namespace arimis\integral\rule;

interface RuleGroupInterface {
	
	/**
	 * @return string
	 */
	public function getName();
	
	/**
	 * @param string $class
	 * @return RuleGroupInterface
	 */
	public function setClass($class);
	
	/**
	 * @param boolean $stackable
	 * @return RuleGroupInterface
	 */
	public function setStackable($stackable);
	
	/**
	 * @return boolean
	 */
	public function isStackable();
	
	/**
	 * @return RuleInterface[]
	 */
	public function getRules();
}