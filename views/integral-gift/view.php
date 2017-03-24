<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model arimis\integral\models\IntegralGift */

$this->title = $model->gift_code;
$this->params['breadcrumbs'][] = ['label' => Yii::t('arimis-integral', 'Integral Gifts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="integral-gift-view">

    <p>
        <?= Html::a(Yii::t('arimis-integral', 'Update'), ['update', 'id' => $model->gift_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('arimis-integral', 'Delete'), ['delete', 'id' => $model->gift_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('arimis-integral', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'gift_id',
            'gift_code',
            'gift_name',
            'gift_list_pic',
            'gift_points',
            'gift_quantity',
            'gift_cost',
            'gift_purchase_price',
            'gift_desc:ntext',
            'is_onsale',
            'sort',
            'create_time',
            'modify_time',
            'create_admin',
        ],
    ]) ?>

</div>
