<?php
/**
 * Created by Arimis Wang using eclipse neon on 2017年3月13日11:39:44
 * @package arimis\integral
 * @author Arimis Wang
 * @date 2017年3月13日
 * @license 上海珂兰商贸有限公司
 * @link wangwengang@kela.cn
 */

namespace arimis\integral;

use arimis\integral\rule\RulableTargetInterface;
use arimis\integral\rule\RuleConditionInterface;
use yii\base\Object;
use yii\base\UnknownClassException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

class IntegralFactory extends Object {
	/**
	 * 通过工场模式创建RulableTargetInterface接口实例
	 * @param string $class
	 * @param array $params
	 * @return RulableTargetInterface
	 * @throws UnknownClassException|InvalidArgumentException
	 */
	public static function createTarget($class, array $params = []) {
		if(!class_exists($class)) {
			throw new UnknownClassException($class);
		}
		
		$target = new $class($params);
		if(!$target instanceof RulableTargetInterface) {
			throw new InvalidArgumentException("Parameter 1 should be an class name for Class implements the RulableTargetInterface!");
		}
		
		return $target;
	}
	
	/**
	 * 创建 RuleInterface 对象
	 * @param string $class
	 * @param RuleConditionInterface $condition
	 * @return RuleInterface
     * @throws UnknownClassException|InvalidArgumentException
	 */
	public static function createRule($class, RuleConditionInterface $condition) {
		if(!class_exists($class)) {
			throw new UnknownClassException($class);
		}
		
		if(!$condition instanceof RuleConditionInterface) {
			throw new InvalidArgumentException("Parameter 1 should be an class name for Class implements the RuleConditionInterface!");
		}
		
		$rule = new $class($condition);
		if(!$rule instanceof RuleInterface) {
			throw new InvalidArgumentException("Parameter 1 should be an class name for Class implements the RuleInterface!");
		}
		
		return $rule;
	}
}