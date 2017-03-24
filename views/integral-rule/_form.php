<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use arimis\integral\rule\RuleInterface;

/* @var $this yii\web\View */
/* @var $model arimis\integral\models\IntegralRule */
/* @var $form yii\widgets\ActiveForm */
/**
 * @var \arimis\integral\IntegralServiceInterface $integral
 * @var string[] $targetClasses
 * @var string $scopeClass
 * @var boolean $isOpenRuleScopeCtrl
 * @var string[] $targetList
 * @var string[][] $conditionColumnList
 * @var string[] $invokeStatusColumnList
 * @var string[][] $invokeStatusValuesList
 * @var string[][] $scopeList
 * @var boolean[][] $isDynamicPointList
 */
$this->title = Yii::t("arimis-integral", "Integral Rule Management");
$defaultTargetClass = empty($model->target_class_name) ? current($targetClasses) : $model->target_class_name;
reset($targetClasses);
$defaultConditionColumns = $conditionColumnList[$defaultTargetClass];
$defaultInvokeStatusColumn = $invokeStatusColumnList[$defaultTargetClass];
$defaultInvokeStatusValues = $invokeStatusValuesList[$defaultTargetClass];
$defaultIsDynamicPoints = $isDynamicPointList[$defaultTargetClass];

$defaultConditionShowStyle = "style='display:none'";
if($defaultConditionColumns && count($defaultConditionColumns) > 1) {
    $defaultConditionShowStyle = '';
}

$defaultInvokeStatusShowStyle = "style='display:none'";
if($defaultInvokeStatusColumn && count($defaultInvokeStatusColumn) > 0) {
    $defaultInvokeStatusShowStyle = "";
}

$defaultChangeTypeShowStyle = "style='display:none'";
if(!$defaultIsDynamicPoints) {
    $defaultChangeTypeShowStyle = "";
}

$jsonIsDynamicPointList = json_encode($isDynamicPointList);
$jsonConditionColumnList = json_encode($conditionColumnList);
$jsonInvokeStatusColumnList = json_encode($invokeStatusColumnList);
$jsonInvokeStatusValuesList = json_encode($invokeStatusValuesList);
$jsInPage = <<<EOF
    var _isDynamicPointList = {$jsonIsDynamicPointList};
    var _conditionColumnList = {$jsonConditionColumnList};
    var _invokeStatusColumnList = {$jsonInvokeStatusColumnList};
    var _invokeStatusValuesList = {$jsonInvokeStatusValuesList};
    $("document").ready(function() {
        $("document").delegate("#integralrule-target_class_name", "change", function() {
            var targetClass = $(this).val();
            var item, label;
            //condition column changes
            var conditionColumns = _conditionColumnList[targetClass];

            var conditionColumnOptionsHtml = "";
            for(item in conditionColumns) {
                label = conditionColumns[item];
                conditionColumnOptionsHtml += "<option value='" + item + "'>" + label + "</option>";
            }
            $("#integralrule-condition_column").html(conditionColumnOptionsHtml);

            if(conditionColumns && conditionColumns.length() > 0) {
                $("#condition_column_container").show();
                $("#condition_type_container").show();
                $("#condition_value_range_container").show();
            }
            else {
                $("#condition_column_container").hide();
                $("#condition_type_container").hide();
                $("#condition_value_range_container").hide();
            }

            //invoke status column changes
            var invokeStatusColumn = _invokeStatusColumnList[targetClass];
            $("#integralrule-invoke_status_column").val(invokeStatusColumn);
            if(invokeStatusColumn && invokeStatusColumn.length > 0) {
                //invoke status values changes
                var invokeStatusValues = _invokeStatusValuesList[targetClass];
                var invokeStatusValueOptionsHtml = "";
                for(item in invokeStatusValues) {
                    label = invokeStatusValues[item];
                    invokeStatusValueOptionsHtml += "<option value='" + item + "'>" + label + "</option>";
                }
                $("#integralrule-invoke_status_value_before").html(invokeStatusValueOptionsHtml);
                $("#integralrule-invoke_status_value_target").html(invokeStatusValueOptionsHtml);

                $('#invoke_status_column_container').show();
                $('#invoke_status_value_before_container').show();
                $('#invoke_status_value_target_container').show();
            }
            else {
                $('#invoke_status_column_container').hide();
                $('#invoke_status_value_before_container').hide();
                $('#invoke_status_value_target_container').hide();

            }

            //dynamic points settings changes
            var isDynamicPoints = _isDynamicPointList[targetClass];
            if(isDynamicPoints) {
                $('#change_type_container').hide();
                $('#change_points_container').hide();
            }
            else {
                $('#change_type_container').show();
                $('#change_points_container').show();
            }

        });

        $('#integralrule-change_frequency_type').delegate("input", "click", function () {
            var val = $(this).val();
            if(val == 3) {
                $('#change_frequency_value_container').show();
            }
            else {
                $('#change_frequency_value_container').hide();
            }
        });
    });
EOF;

$this->registerJs($jsInPage);
?>

<div class="integral-rule-form">

    <?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-lg-4 col-md-6 col-sm-12">
        <?= $form->field($model, 'rule_code')->textInput(['maxlength' => true, 'readonly' => true]) ?>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-12">
    <?= $form->field($model, 'rule_name')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-12">
    <?= $form->field($model, 'is_active')->radioList(['0' => '否', '1' => '是'], ['inline' => true, 'value' => empty($model->is_active) ? '0' : '1']) ?>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-12">
        <?= $form->field($model, 'target_class_name')->dropDownList($targetList, ['maxlength' => true]) ?>
    </div>
    <?php if($isOpenRuleScopeCtrl):
        ?>
    <div class="col-lg-4 col-md-6 col-sm-12">
    <?= $form->field($model, 'scope')->dropDownList($scopeList, ['maxlength' => true]) ?>
    </div>
    <?php endif;?>
    <div class="col-lg-4 col-md-6 col-sm-12" id="condition_column_container" <?=$defaultConditionShowStyle?>>
    <?= $form->field($model, 'condition_column')->dropDownList($defaultConditionColumns, ['maxlength' => true]) ?>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-12" id="condition_type_container" <?=$defaultConditionShowStyle?>>
    <?= $form->field($model, 'condition_type')->dropDownList([
        RuleInterface::RANGE_TYPE_EQUALS => RuleInterface::RANGE_TYPE_EQUALS,
        RuleInterface::RANGE_TYPE_GREAT_THAN => RuleInterface::RANGE_TYPE_GREAT_THAN,
        RuleInterface::RANGE_TYPE_GREAT_THAN_AND_EQUALS => RuleInterface::RANGE_TYPE_GREAT_THAN_AND_EQUALS,
        RuleInterface::RANGE_TYPE_LESS_THAN => RuleInterface::RANGE_TYPE_LESS_THAN,
        RuleInterface::RANGE_TYPE_LESS_THAN_AND_EQUALS => RuleInterface::RANGE_TYPE_LESS_THAN_AND_EQUALS,
        RuleInterface::RANGE_TYPE_BETWEEN => RuleInterface::RANGE_TYPE_BETWEEN . " 两值之间用英文逗号分隔",
        RuleInterface::RANGE_TYPE_IN => RuleInterface::RANGE_TYPE_IN . " 多值之间用英文逗号分隔",
    ], ['maxlength' => true]) ?>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-12" id="condition_value_range_container" <?=$defaultConditionShowStyle?>>
    <?= $form->field($model, 'condition_value_range')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-lg-4 col-md-6 col-sm-12" id="invoke_status_column_container" <?=$defaultInvokeStatusShowStyle?>>
        <?= $form->field($model, 'invoke_status_column')->dropDownList(!$defaultInvokeStatusColumn ? [] : $defaultInvokeStatusColumn, ['maxlength' => true, 'readonly' => true, empty($model->invoke_status_column) ? (empty($model->target_class_name) ? current($invokeStatusColumnList) : $invokeStatusColumnList[$model->target_class_name]) : $model->invoke_status_column]) ?>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-12" id="invoke_status_value_before_container" <?=$defaultInvokeStatusShowStyle?>>
        <?= $form->field($model, 'invoke_status_value_before')->dropDownList(empty($model->target_class_name) ? current($invokeStatusValuesList) : $invokeStatusValuesList[$model->target_class_name], ['maxlength' => true]) ?>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-12" id="invoke_status_value_target_container" <?=$defaultInvokeStatusShowStyle?>>
        <?= $form->field($model, 'invoke_status_value_target')->dropDownList(empty($model->target_class_name) ? current($invokeStatusValuesList) : $invokeStatusValuesList[$model->target_class_name], ['maxlength' => true]) ?>
    </div>

    <!--<div class="col-lg-4 col-md-6 col-sm-12">
        <?/*= $form->field($model, 'invoke_data_storage_status')->radioList([
                RuleInterface::DATA_STORAGE_STATUS_CREATED => "创建时",
                RuleInterface::DATA_STORAGE_STATUS_UPDATED => "变更时"
        ], ['inline' => true, 'value' => empty($model->invoke_data_storage_status) ? RuleInterface::DATA_STORAGE_STATUS_CREATED : $model->invoke_data_storage_status]) */?>
    </div>-->
    <!--<div class="col-lg-4 col-md-6 col-sm-12">
    <?/*= $form->field($model, 'group')->textInput(['maxlength' => true]) */?>
    </div>-->
    <div class="col-lg-4 col-md-6 col-sm-12">
    <?= $form->field($model, 'weight')->textInput() ?>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-12">
    <?= $form->field($model, 'stackable')->radioList([
            '0' => '否',
            '1' => '是'
    ], ['inline' => true, 'value' => empty($model->stackable) ? '0' : $model->stackable]) ?>
    </div>
    <!--<div class="col-lg-4 col-md-6 col-sm-12">
        <?/*= $form->field($model, 'is_dynamic_point')->radioList([
            '0' => '否',
            '1' => '是'
        ], ['inline' => true, 'value' => empty($model->is_dynamic_point) ? '0' : '1']) */?>
    </div>-->

    <div class="col-lg-4 col-md-6 col-sm-12" id="change_type_container" <?=$defaultChangeTypeShowStyle?>>
        <?= $form->field($model, 'change_type')->radioList([
            RuleInterface::INTEGRAL_CHANGE_TYPE_INCREASE => '增加',
            RuleInterface::INTEGRAL_CHANGE_TYPE_REDUCE => '减少',
            RuleInterface::INTEGRAL_CHANGE_TYPE_FROZE => '冻结',
            RuleInterface::INTEGRAL_CHANGE_TYPE_THAW => '解冻'
        ], ['inline' => true, 'value' => empty($model->change_type) ? RuleInterface::INTEGRAL_CHANGE_TYPE_INCREASE : $model->change_type]) ?>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-12" id="change_points_container" <?=$defaultChangeTypeShowStyle?>>
        <?= $form->field($model, 'change_points')->textInput() ?>
    </div>

    <div class="col-lg-4 col-md-6 col-sm-12">
    <?= $form->field($model, 'change_frequency_type')->radioList([
        RuleInterface::CHANGE_FREQUENCY_TYPE_ONLY_ONCE => '只执行一次性',
        RuleInterface::CHANGE_FREQUENCY_TYPE_EVERY_TIME => '每次都执行',
        RuleInterface::CHANGE_FREQUENCY_TYPE_REGULARLY => '周期性执行，需配置下方的频率'
    ], ['inline' => true, 'value' => empty($model->change_frequency_type) ? RuleInterface::CHANGE_FREQUENCY_TYPE_ONLY_ONCE : $model->change_frequency_type]) ?>
    </div>

    <div class="col-lg-4 col-md-6 col-sm-12" style="<?php if($model->change_frequency_type != RuleInterface::CHANGE_FREQUENCY_TYPE_REGULARLY):?>display:none;<?php endif;?>" id="change_frequency_value_container">
    <?= $form->field($model, 'change_frequency_value')->radioList([
        RuleInterface::CHANGE_FREQUENCY_VAL_EVERY_DAY => '每天一次',
        RuleInterface::CHANGE_FREQUENCY_VAL_EVERY_WEEK => '每周一次',
        RuleInterface::CHANGE_FREQUENCY_VAL_EVERY_MONTH => '每月一次',
        RuleInterface::CHANGE_FREQUENCY_VAL_EVERY_SEASON => '每季一次',
        RuleInterface::CHANGE_FREQUENCY_VAL_EVERY_YEAR => '每年一次',
    ], ['inline' => true, 'value' => empty($model->change_frequency_value) ? RuleInterface::CHANGE_FREQUENCY_VAL_EVERY_DAY : $model->change_frequency_value]) ?>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-12">
    <?= $form->field($model, 'time_start')->widget(\dosamigos\datetimepicker\DateTimePicker::className(), [
        'model' => $model,
        'language' => "zh-CN",
        'attribute' => "birthday",
        'field' => $form->field($model, 'time_start'),
        "template" => "{button}{input}{reset}",
        "clientOptions" => [
            'autoclose' => true,
            'format' => "yyyy-mm-dd hh:ii:ss",
            'maxView' => '3',
            'minView' => "0",
            'todayHighlight' > true
        ],
        'clientEvents' => []
    ]) ?>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-12">
    <?= $form->field($model, 'time_end')->widget(\dosamigos\datetimepicker\DateTimePicker::className(), [
        'model' => $model,
        'language' => "zh-CN",
        'attribute' => "birthday",
        'field' => $form->field($model, 'time_end'),
        "template" => "{button}{input}{reset}",
        "clientOptions" => [
            'autoclose' => true,
            'format' => "yyyy-mm-dd hh:ii:ss",
            'maxView' => '3',
            'minView' => "0",
            'todayHighlight' > true
        ],
        'clientEvents' => []
    ]) ?>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-12">
        <?= $form->field($model, 'rule_desc')->textarea(['rows' => 6]) ?>
    </div>
    <div class="form-group col-lg-12 col-md-12 col-sm-12">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('arimis-integral', 'Create') : Yii::t('arimis-integral', 'Update'), ['class' => ($model->isNewRecord ? 'btn btn-success' : 'btn btn-primary') . " pull-right"]) ?>
    </div>
</div>
    <?php ActiveForm::end(); ?>

</div>
