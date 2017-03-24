<?php
/**
 * Created by IntelliJ IDEA.
 * User: Arimis
 * Date: 2017/3/15
 * Time: 12:11
 */

namespace arimis\integral\rule;


use yii\db\ActiveRecordInterface;

interface RuleSettingInterface extends ActiveRecordInterface
{
    /**
     * @return double
     */
    public function getIntegralCashExchangeRate();

    /**
     * @param double $rate
     * @return mixed
     */
    public function setIntegralCashExchangeRate($rate);

    /**
     * @param boolean $status
     * @return mixed
     */
    public function setIntegralOpenStatus($status);

    /**
     * @param boolean $open
     * @return mixed
     */
    public function setOpenExpress($open);
}