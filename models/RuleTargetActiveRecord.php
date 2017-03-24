<?php
/**
 * Created by IntelliJ IDEA.
 * User: Arimis
 * Date: 2017/3/22
 * Time: 15:59
 */

namespace arimis\integral\models;


use arimis\integral\Integral;
use arimis\integral\IntegralUserInterface;
use arimis\integral\rule\RulableTargetInterface;
use yii\db\ActiveRecord;

abstract class RuleTargetActiveRecord extends ActiveRecord implements RulableTargetInterface
{
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        //执行积分规则
        Integral::runIntegralRule($this);
    }
}