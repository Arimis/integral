<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model arimis\integral\models\ExchangeOrder */

$this->title = $model->order_sn;
$this->params['breadcrumbs'][] = ['label' => Yii::t('arimis-integral', 'Exchange Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="exchange-order-view">

    <p>
        <?= Html::a(Yii::t('arimis-integral', 'Update'), ['update', 'id' => $model->order_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('arimis-integral', 'Delete'), ['delete', 'id' => $model->order_id], [
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
            'order_id',
            'order_sn',
            'order_points_amount',
            'order_cash_amount',
            'item_quantity',
            'create_time',
            'modify_time',
            'user_code',
            'delivery_type',
            'delivery_fee',
            'consignee',
            'province_name',
            'city_name',
            'direct_name',
            'detail_address',
            'order_status',
        ],
    ]) ?>

</div>
