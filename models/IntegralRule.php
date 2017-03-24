<?php

namespace arimis\integral\models;

use Yii;

/**
 * This is the model class for table "integral_rule".
 *
 * @property integer $rule_id
 * @property string $rule_name
 * @property string $rule_code
 * @property string $rule_desc
 * @property string $target_class_name
 * @property integer $is_active
 * @property string $scope
 * @property integer $is_dynamic_point
 * @property string $condition_column
 * @property string $condition_type
 * @property string $condition_value_range
 * @property string $group
 * @property integer $weight
 * @property integer $stackable
 * @property integer $change_points
 * @property string $change_type
 * @property string $invoke_status_column
 * @property string $invoke_status_value_before
 * @property string $invoke_status_value_target
 * @property integer $change_frequency_type
 * @property string $change_frequency_value
 * @property string $time_start
 * @property string $time_end
 * @property string $create_time
 * @property string $modify_time
 * @property string $create_admin
 * @property IntegralChange[] $ruleChanges
 */
class IntegralRule extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'integral_rule';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rule_name', 'rule_code'], 'required'],
            [['rule_desc'], 'string'],
            [['is_active', 'is_dynamic_point', 'weight', 'stackable', 'change_points', 'change_frequency_type'], 'integer'],
            [['time_start', 'time_end', 'create_time', 'modify_time'], 'safe'],
            [['rule_name', 'condition_column', 'condition_type', 'condition_value_range', 'invoke_status_column', 'invoke_status_value_before', 'invoke_status_value_target', 'change_frequency_value'], 'string', 'max' => 50],
            [['target_class_name'], 'string', 'max' => 255],
            [['scope', 'group'], 'string', 'max' => 10],
            [['change_type'], 'string', 'max' => 8],
            [['rule_code', 'create_admin'], 'string', 'max' => 21],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rule_id' => Yii::t('arimis-integral', 'ID'),
            'rule_code' => Yii::t('arimis-integral', '规则编码'),
            'rule_name' => Yii::t('arimis-integral', '规则名称'),
            'rule_desc' => Yii::t('arimis-integral', '规则描述'),
            'target_class_name' => Yii::t('arimis-integral', '积分变化触发对象'),
            'is_active' => Yii::t('arimis-integral', '生效否'),
            'scope' => Yii::t('arimis-integral', '适用范围，默认为空'),
            'is_dynamic_point' => Yii::t('arimis-integral', '动态配置积分变化值否（如果选择“否”，则需要配置下方“积分变更类型”和“积分变化值”）'),
            'condition_column' => Yii::t('arimis-integral', '触发时过滤条件的字段'),
            'condition_type' => Yii::t('arimis-integral', '触发时过滤条件字段的比较逻辑关系'),
            'condition_value_range' => Yii::t('arimis-integral', '触发条件过滤的字段值逻辑范围边界'),
            'group' => Yii::t('arimis-integral', '分组'),
            'weight' => Yii::t('arimis-integral', '权重'),
            'stackable' => Yii::t('arimis-integral', '允许叠加否'),
            'change_points' => Yii::t('arimis-integral', '积分变化值（如果“动态配置积分变化值否”为“是”,则此字段无效，积分值由对应的“积分变化触发对象”的getDynamicChangePoints()方法提供）'),
            'change_type' => Yii::t('arimis-integral', '积分变更类型（如果“动态配置积分变化值否”为“是”,则此字段无效，变更方式由对应的“积分变化触发对象”的getDynamicChangeType()方法提供）'),
            'invoke_status_column' => Yii::t('arimis-integral', '变更触发的状态控制字段名'),
            'invoke_status_value_before' => Yii::t('arimis-integral', '状态变更前的值'),
            'invoke_status_value_target' => Yii::t('arimis-integral', '状态变更的目标值'),
            'change_frequency_type' => Yii::t('arimis-integral', '规则执行方式（如果是“周期性执行”，需配置“周期性执行频率”）'),
            'change_frequency_value' => Yii::t('arimis-integral', '周期性执行频率'),
            'time_start' => Yii::t('arimis-integral', '有效期开始时间（不限制则留空）'),
            'time_end' => Yii::t('arimis-integral', '有效期结束时间（不限制则留空）'),
            'create_time' => Yii::t('arimis-integral', 'Create Time'),
            'modify_time' => Yii::t('arimis-integral', 'Modify Time'),
            'create_admin' => Yii::t('arimis-integral', 'Create Admin'),
        ];
    }

    public function getRuleChanges()
    {
        return $this->hasMany(IntegralChange::className(), ['rule_code' => 'rule_code']);
    }
}
