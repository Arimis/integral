<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model arimis\integral\models\IntegralGift */
/* @var $form yii\widgets\ActiveForm */
$inPageJs = <<<EOF
    <!-- 初始化列表圖片,修復上傳組件bug -->
    $(':hidden[name="IntegralGift[gift_list_pic]"]').val("{$model->gift_list_pic}");
    $('#saveBtn').click(function() {
        $('#integralgift-gift_list_pic').attr('name', 'none');
    });
EOF;
$this->registerJs($inPageJs);
?>

<div class="integral-gift-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'gift_code')->textInput(['maxlength' => true, 'readonly' => true]) ?>

    <?= $form->field($model, 'gift_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gift_list_pic')->widget(\kartik\file\FileInput::classname(),
        ['options' => ['multiple' => false],
           'pluginOptions' => [
               // 需要预览的文件格式
               'previewFileType' => 'image',
               // 预览的文件
               'initialPreview' => [empty($model->gift_list_pic) ? "" : $model->gift_list_pic],
               // 需要展示的图片设置，比如图片的宽度等
               'initialPreviewConfig' => [
                   ['url' => \yii\helpers\Url::toRoute("/integral/integral-gift/del-list-pic?gift_code=" . $model->gift_code)]
               ],
               // 是否展示预览图
               'initialPreviewAsData' => true,
               // 异步上传的接口地址设置
               'uploadUrl' => \yii\helpers\Url::toRoute(['/integral/integral-gift/upload-list-pic?gift_code=' . $model->gift_code]),
               // 异步上传需要携带的其他参数，比如商品id等
               'uploadExtraData' => [
                   'id' => $model->gift_id,
               ],
               'uploadAsync' => true,
               // 最少上传的文件个数限制
               'minFileCount' => 1,
               // 最多上传的文件个数限制
               'maxFileCount' => 1,
               // 是否显示移除按钮，指input上面的移除按钮，非具体图片上的移除按钮
               'showRemove' => true,
               // 是否显示上传按钮，指input上面的上传按钮，非具体图片上的上传按钮
               'showUpload' => true,
               //是否显示[选择]按钮,指input上面的[选择]按钮,非具体图片上的上传按钮
               'showBrowse' => true,
               // 展示图片区域是否可点击选择多文件
               'browseOnZoneClick' => true,
               // 如果要设置具体图片上的移除、上传和展示按钮，需要设置该选项
               'fileActionSettings' => [
                   // 设置具体图片的查看属性为false,默认为true
                   'showZoom' => true,
                   // 设置具体图片的上传属性为true,默认为true
                   'showUpload' => true,
                   // 设置具体图片的移除属性为true,默认为true
                   'showRemove' => true,
               ],
           ],
           // 一些事件行为
           'pluginEvents' => [
               'filepreajax' => "function(event, previewId, index) {
                console.log('filepreajax:' + $('#integralgift-gift_list_pic').attr('name'));
                $('#integralgift-gift_list_pic').attr('name', 'IntegralGift[gift_list_pic]');
                console.log('filepreajax:' + $('#shopproddia-dia_picture').attr('name'));
            }",
           // 上传成功后的回调方法，需要的可查看data后再做具体操作，一般不需要设置
           "fileuploaded" => "function (event, data, id, index) {
                $('#integralgift-gift_list_pic').attr('name', 'none');
                $(':input[name=\"IntegralGift[gift_list_pic]\"]').val(data.response.data);
            }",
                                                                               ],
    ]); ?>

    <?= $form->field($model, 'gift_points')->textInput(['value' => empty($model->gift_points) ? 0 : $model->gift_points]) ?>

    <?= $form->field($model, 'gift_quantity')->textInput(['value' => empty($model->gift_quantity) ? 0 : $model->gift_quantity]) ?>

    <?= $form->field($model, 'gift_cost')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gift_purchase_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gift_desc')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'is_onsale')->radioList([
        '0' => Yii::t('app', '否'),
        '1' => Yii::t("app", "是")
    ], ['value' => empty($model->is_onsale) ? 0 : $model->is_onsale]); ?>

    <?= $form->field($model, 'sort')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('arimis-integral', 'Create') : Yii::t('arimis-integral', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'id' => 'saveBtn']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
