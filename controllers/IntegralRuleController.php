<?php

namespace arimis\integral\controllers;

use arimis\integral\IntegralServiceInterface;
use arimis\UniqueCodeService;
use Yii;
use arimis\integral\models\IntegralRule;
use arimis\integral\models\IntegralRuleSearch;
use arimis\integral\controllers\IntegralBaseController;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * IntegralRuleController implements the CRUD actions for IntegralRule model.
 */
class IntegralRuleController extends IntegralBaseController
{
    /**
     * @var IntegralServiceInterface
     */
    public $integral;
    public $targetClasses;
    public $scopeClass;
    public $isOpenRuleScopeCtrl = true;

    public function beforeAction($action)
    {
        if(!parent::beforeAction($action)) {
            return false;
        }
        $this->integral = Yii::$app->integral;
        $this->targetClasses = $this->integral->getIntegralTargetSettings();
        $this->scopeClass = $this->integral->getIntegralScopeSetting();
        $this->isOpenRuleScopeCtrl = $this->integral->isOpenRuleScopeCtrl();

        return true;
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all IntegralRule models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new IntegralRuleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single IntegralRule model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new IntegralRule model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new IntegralRule();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->rule_id]);
        } else {
            (new UniqueCodeService($model, "rule_code"))->getCurrentCode();
            return $this->render('create', ['param' => ArrayHelper::merge([
                'model' => $model,
                'targetClasses' => $this->targetClasses,
                'scopeClass' => $this->scopeClass,
                'integral' => $this->integral,
                'isOpenRuleScopeCtrl' => $this->isOpenRuleScopeCtrl,
            ], $this->prepareIntegralData())]);
        }
    }


    /**
     * Updates an existing IntegralRule model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->rule_id]);
        } else {
            return $this->render('update', ['param' => ArrayHelper::merge([
                'model' => $model,
                'targetClasses' => $this->targetClasses,
                'scopeClass' => $this->scopeClass,
                'integral' => $this->integral,
                'isOpenRuleScopeCtrl' => $this->isOpenRuleScopeCtrl,
            ], $this->prepareIntegralData())]);
        }
    }

    /**
     * Deletes an existing IntegralRule model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * @return array
     */
    protected function prepareIntegralData()
    {
        $targetList = [];
        $conditionColumnList = [];
        $invokeStatusColumnList = [];
        $invokeStatusValuesList = [];
        $scopeList = [];
        $isDynamicPointList = [];
        foreach ($this->targetClasses as $targetClass) {
            $targetList[$targetClass] = $targetClass::getTargetName() . ($targetClass::isDynamicPoints() ? "(动态积分)" : "");
            $conditionColumnList[$targetClass] = ArrayHelper::merge(['' => '选择……'], (array)$targetClass::conditionColumnsMap());
            $invokeStatusColumnList[$targetClass] = $targetClass::getInvokeStatusColumnName() ? [ $targetClass::getInvokeStatusColumnName() => $targetClass::getInvokeStatusColumnLabel() ] : false;
            $invokeStatusValuesList[$targetClass] = ArrayHelper::merge(['' => '选择……'], (array)$targetClass::getInvokeStatusMap());
            $isDynamicPointList[$targetClass] = ArrayHelper::merge(['' => '选择……'], (array)$targetClass::isDynamicPoints());
        }
        if($this->isOpenRuleScopeCtrl) {
            $scopeClass = $this->scopeClass;
            $integralScopeList = $scopeClass::getAuthorizedScope(Yii::$app->user->getId());
            if(count($integralScopeList) > 0) {
                array_map(function($value) use(&$scopeList) {
                    $scopeList[$value->getScopeValue()] = $value->getScopeName();
                }, $integralScopeList);
                unset($integralScopeList);
            }
            else {
                $scopeList = $integralScopeList;
            }
        }

        return [
            'targetList' => $targetList,
            'conditionColumnList' => $conditionColumnList,
            'invokeStatusColumnList' => $invokeStatusColumnList,
            'invokeStatusValuesList' => $invokeStatusValuesList,
            'scopeList' => $scopeList,
            'isDynamicPointList' => $isDynamicPointList
        ];
    }

    /**
     * Finds the IntegralRule model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return IntegralRule the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = IntegralRule::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
