<?php

namespace arimis\integral\models;

use Yii;

/**
 * This is the model class for table "integral_change".
 *
 * @property integer $log_id
 * @property string $user_code
 * @property string $rule_code
 * @property string $target_unique_key
 * @property string $change_desc
 * @property string $change_type
 * @property integer $change_points
 * @property integer $before_available
 * @property integer $after_available
 * @property integer $before_frozen
 * @property integer $after_frozen
 * @property string $params
 * @property string $create_time
 * @property string $modify_time
 * @property string $create_admin
 * @property IntegralRule $ruleCode
 */
class IntegralChange extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'integral_change';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['change_points', 'before_available', 'after_available', 'before_frozen', 'after_frozen'], 'integer'],
            [['create_time', 'modify_time'], 'safe'],
            [['rule_code', 'user_code', 'create_admin'], 'string', 'max' => 21],
            [['change_desc'], 'string', 'max' => 50],
            [['target_unique_key'], 'string', 'max' => 32],
            [['change_type'], 'string', 'max' => 8],
            [['params'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'log_id' => Yii::t('app', 'Log ID'),
            'rule_code' => Yii::t('app', '规则编码'),
            'target_unique_key' => Yii::t('app', '排重编码'),
            'user_code' => Yii::t('app', '用户编码'),
            'change_desc' => Yii::t('app', '变更说明'),
            'change_type' => Yii::t('app', '数值变更方式：increase, reduce, froze, thaw'),
            'change_points' => Yii::t('app', '变更的积分值'),
            'before_available' => Yii::t('app', '变更前'),
            'after_available' => Yii::t('app', '变更后的积分值'),
            'before_frozen' => Yii::t('app', '变更前'),
            'after_frozen' => Yii::t('app', '变更后的积分值'),
            'params' => Yii::t('app', '涉及的相关参数，备份查询用'),
            'create_time' => Yii::t('app', 'Create Time'),
            'modify_time' => Yii::t('app', 'Modify Time'),
            'create_admin' => Yii::t('app', 'Create Admin'),
        ];
    }

    /**
     * @inheritdoc
     * @return IntegralChangeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new IntegralChangeQuery(get_called_class());
    }

    public function getRuleCode()
    {
        return $this->hasOne(IntegralRule::className(), ['rule_code' => 'rule_code']);
    }
}
