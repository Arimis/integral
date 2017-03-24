<?php
/**
 * Created by IntelliJ IDEA.
 * User: Arimis
 * Date: 2017/3/15
 * Time: 17:34
 */

namespace arimis\integral\controllers;


use arimis\integral\IntegralServiceInterface;
use arimis\integral\IntegralUserInterface;
use arimis\integral\models\ExchangeOrder;
use arimis\integral\models\ExchangeOrderItem;
use arimis\integral\models\IntegralChangeSearch;
use arimis\integral\models\IntegralGift;
use arimis\integral\UniqueCodeService;
use yii\data\ActiveDataProvider;
use yii\db\Exception;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class UserIntegralController extends IntegralBaseController
{
    public $isFrontend = true;
    public function beforeAction($action)
    {
        if(!parent::beforeAction($action)) {
            return false;
        }
        /**
         * @var IntegralServiceInterface $integralService
         */
        $integralService = \Yii::$app->integral;
        if(empty($integralService->getIntegralUser())) {
            $integralUserClassName = $integralService->getIntegralUserSetting();
            $loginUrl = $integralUserClassName::getLoginUrl();
            $this->redirect($loginUrl);
            return false;
        }
        if(isset($this->module->frontendLayoutPath) && !empty($this->module->frontendLayoutPath)) {
            $this->module->layoutPath = $this->module->frontendLayoutPath;
        }
        if(isset($this->module->frontendLayout) && !empty($this->module->frontendLayout)) {
            $this->module->layout = $this->module->frontendLayout;
        }
        else {
            $this->module->layout = 'frontend';
        }
        $this->layout = $this->module->layoutPath ."/" . $this->module->layout . '.php';
        return true;
    }

    /**
     * 积分日志
     * @return string
     */
    public function actionIndex() {
        $model = new IntegralChangeSearch();
        $params = \Yii::$app->getRequest()->get();
        $data = $model->search($params);
        /**
         * @var IntegralServiceInterface
         */
        $integral = \Yii::$app->integral;
        return $this->render("index", [
            'dataProvider' => $data,
            'searchModel' => $model,
            'userBase' => $integral->getIntegralUser()
        ]);
    }

    /**
     * 礼物列表
     * @return string
     */
    public function actionGift() {
        /**
         * @var IntegralUserInterface $user
         */
        $user = \Yii::$app->integral->getIntegralUser();
        $query = IntegralGift::find();
        $data = $query->where(['is_onsale' => 1])->orderBy("sort asc")->limit(10)->offset(0)->all();
        return $this->render('gift',[
            'data' => $data,
            'userBase' => $user
        ]);
    }

    /**
     * 礼物详情
     */
    public function actionView() {
        $giftCode = \Yii::$app->getRequest()->get('gift_code');
        $model = $this->findModelByCode($giftCode);

        return $this->render("view", [
            'model' => $model
        ]);
    }

    public function actionExchange() {
        /**
         * @var IntegralUserInterface $userBase
         */
        $userBase = \Yii::$app->integral->getIntegralUser();
        $giftCodeStr = \Yii::$app->getRequest()->get("gift_codes");
        if(empty($giftCodeStr)) {
            throw new \InvalidArgumentException(\Yii::t("arimis-integral", 'You should provide a valid gift code!'));
        }

        $giftCodes = explode(",", $giftCodeStr);
        $query = IntegralGift::find()->where(["IN", 'gift_code', $giftCodes]);
        $totalPoints = $query->sum("gift_points");
        $gifts = $query->all();
        return $this->render("exchange", [
            'gifts' => $gifts,
            'totalPoints' => $totalPoints,
            'userBase' => $userBase,
            'giftCodes' => $giftCodeStr
        ]);
    }

    public function actionMakeExchangeOrder() {
        if(!\Yii::$app->getRequest()->getIsAjax() || !\Yii::$app->getRequest()->getIsPost()) {
            return json_encode(['code' => 0, 'msg' => \Yii::t("arimis-integral", 'You should request this action by ajax post!')]);
        }
        /**
         * @var IntegralUserInterface $userBase
         */
        $userBase = \Yii::$app->integral->getIntegralUser();
        $giftCodeStr = \Yii::$app->getRequest()->post("giftCodes");
        if(empty($giftCodeStr)) {
            return json_encode(['code' => 0, 'msg' => \Yii::t("arimis-integral", 'You should provide a valid gift code!')]);
        }

        $transaction = \Yii::$app->getDb()->beginTransaction();
        $code = 0;
        $msg = \Yii::t("arimis-integral", "Sorry, it is failed");
        try {
            $giftCodes = explode(",", $giftCodeStr);
            $query = IntegralGift::find()->where(["IN", 'gift_code', $giftCodes]);
            $totalPoints = $query->sum("gift_points");
            $totalCash = $query->sum("gift_cost");
            $gifts = $query->all();
            $exchangeOrder = new ExchangeOrder();
            (new UniqueCodeService($exchangeOrder, "order_sn"))->getCurrentCode();
            $exchangeOrder->item_quantity = count($gifts);
            $exchangeOrder->order_points_amount = $totalPoints;
            $exchangeOrder->order_cash_amount = $totalCash;
            $exchangeOrder->delivery_type = 1;
            $exchangeOrder->user_code = $userBase->getUniqueIdentifyID();
            $exchangeOrder->create_time = date("Y-m-d H:i:s");

            if(!$exchangeOrder->save()) {
                throw  new Exception(\Yii::t("arimis-integral", "Exchange order save failed!"));
            }

            foreach ($gifts as $gift) {
                /**
                 * @var IntegralGift $gift
                 */
                $exchangeOrderItem = new ExchangeOrderItem();
                $exchangeOrderItem->user_code = $userBase->getUniqueIdentifyID();
                $exchangeOrderItem->order_sn = $exchangeOrder->order_sn;
                $exchangeOrderItem->item_code = $gift->gift_code;
                $exchangeOrderItem->item_cost = $gift->gift_cost;
                $exchangeOrderItem->item_name = $gift->gift_name;
                $exchangeOrderItem->item_points = $gift->gift_points;
                $exchangeOrderItem->item_price = $gift->gift_purchase_price;
                $exchangeOrderItem->list_picture = $gift->gift_list_pic;
                $exchangeOrderItem->total_amount = $gift->gift_purchase_price * 1;
                $exchangeOrderItem->total_cost = $gift->gift_cost * 1;
                $exchangeOrderItem->total_points = $gift->gift_points * 1;
                $exchangeOrderItem->quantity = 1;
                if(!$exchangeOrderItem->save()) {
                    throw new Exception(\Yii::t("arimis-integral", "Save gift item [{gift_code}] failed", ['gift_code' => $gift->gift_code]));
                }
            }
            $transaction->commit();
            $code = 1;
            $msg = $exchangeOrder->order_sn;
        }
        catch (Exception $e) {
            $transaction->rollBack();
            $code = 0;
            $msg = $e->getMessage();
        }
        return json_encode([
            'code' => $code,
            'msg' => $msg
        ]);
    }

    public function actionExchangeOrders()
    {
        $page = \Yii::$app->getRequest()->get('page');
        if(empty($page) || $page < 1) {
            $page = 1;
        }
        /**
         * @var IntegralUserInterface $userBase
         */
        $userBase = \Yii::$app->integral->getIntegralUser();
        $query = ExchangeOrder::find();
        $query->where([]);
        $total = $query->count();
        $query->orderBy('create_time DESC');
        $query->limit(10);
        $query->offset(($page - 1) * 10);
        $orderSnArr = $query->select("order_sn")->column();
        $orders = $query->select("*")->all();
        $itemQuery = ExchangeOrderItem::find();
        $orderItems = $itemQuery->where(['IN', 'order_sn', $orderSnArr])
            ->all();

        /**
         * @var ExchangeOrderItem[]
         */
        $orderList = [];
        /**
         * @var ExchangeOrderItem[]
         */
        $itemList = [];
        array_map(function($order) use(&$orderList) {
            /**
             * @var ExchangeOrder $order
             */
            $orderList[$order->order_sn] = $order;
        }, $orders);

        array_map(function($orderItem) use(&$itemList) {
            /**
             * @var ExchangeOrderItem $orderItem
             */
            $itemList[$orderItem->order_sn][$orderItem->item_id] = $orderItem;
        }, $orderItems);
        return $this->render("exchange-orders", [
            'orderList' => $orderList,
            'itemList' => $itemList,
            'total' => $total,
            'userBase' => $userBase
        ]);
    }

    public function actionExchangeOrderView() {
        $orderSn = \Yii::$app->getRequest()->get("order_sn");
        if(empty($orderSn)) {
            throw new BadRequestHttpException(\Yii::t("arimis-integral", "You should provide a invalid order sn"));
        }
        $order = ExchangeOrder::findOne(['order_sn' => $orderSn]);
        if(empty($orderSn)) {
            throw new NotFoundHttpException(\Yii::t("arimis-integral", "You should provide a invalid order sn"));
        }

        $items = ExchangeOrderItem::findAll(['order_sn' => $orderSn]);
        return $this->render("exchange-order-view", [
            'order' => $order,
            'items' => $items
        ]);
    }

    /**
     * @param $giftCode
     * @return IntegralGift
     * @throws NotFoundHttpException
     */
    private function findModelByCode($giftCode) {
        $model = IntegralGift::findOne(['gift_code' => $giftCode]);
        if(empty($model)) {
            throw new NotFoundHttpException();
        }
        return $model;
    }
}