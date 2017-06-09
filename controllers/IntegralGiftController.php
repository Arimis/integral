<?php

namespace arimis\integral\controllers;

use Yii;
use arimis\integral\models\IntegralGift;
use yii\data\ActiveDataProvider;
use arimis\integral\controllers\IntegralBaseController;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * IntegralGiftController implements the CRUD actions for IntegralGift model.
 */
class IntegralGiftController extends IntegralBaseController
{
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
     * 配置百度編輯器圖片上傳
     * @return array
     */
    public function actions()
    {
        $uploadPathFormat = "/upload/editor/{yyyy}{mm}{dd}/{time}{rand:6}";
        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
                'config' => [
                    "imageUrlPrefix"  => Url::base(true),//图片访问路径前缀
                    "imagePathFormat" => $uploadPathFormat //上传保存路径
                ],
            ]
        ];
    }

    /**
     * Lists all IntegralGift models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => IntegralGift::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single IntegralGift model.
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
     * Creates a new IntegralGift model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new IntegralGift();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->gift_id]);
        } else {
            $uniqueServer = new \arimis\integral\UniqueCodeService($model, "gift_code");
            $uniqueServer->getCurrentCode();
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing IntegralGift model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->gift_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing IntegralGift model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDelListPic() {
        $giftCode = Yii::$app->getRequest()->get('gift_code');
        $model = $this->findModelByCode($giftCode);
        $model->gift_list_pic = null;
        $model->save();
        return json_encode([
            'code' => 1,
            'msg' => 'ok'
        ]);
    }

    /**
     * Upload an image for diamond main list picture
     * @return string  A string formatted as json
     * @throws
     */
    public function actionUploadListPic()
    {
        $giftCode = \Yii::$app->request->get('gift_code');
        $model = $this->findModelByCode($giftCode, true);
        $file = UploadedFile::getInstance($model, "gift_list_pic");
        if(empty($file)) {
            throw new BadRequestHttpException(\Yii::t("app", "You did't upload a valid file"));
        }
        $destFile = DIRECTORY_SEPARATOR . "upload" . DIRECTORY_SEPARATOR . "integral_gift" . DIRECTORY_SEPARATOR;
        $md5 = md5(file_get_contents($file->tempName));
        $destFile .= strtolower(substr(ucwords($md5), 0, 4));
        if (! is_dir(\Yii::getAlias('@webroot') . $destFile)) {
            mkdir(\Yii::getAlias('@webroot') . $destFile, 0777, true);
        }
        $destFile .= DIRECTORY_SEPARATOR . $md5 . "." . $file->extension;
        if(!file_exists(\Yii::getAlias('@webroot') . $destFile)) {
            $file->saveAs(\Yii::getAlias('@webroot') . $destFile);
        }

        $rs = [
            'code' => 1,
            'msg' => \Yii::t('app', "upload main list picture successful"),
            'data' => str_replace("\\", "/", $destFile)
        ];
        return json_encode($rs);
    }

    /**
     * Finds the IntegralGift model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return IntegralGift the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = IntegralGift::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Finds the ShopProdDia model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param string $giftCode
     * @param boolean $new if equeal true, then create a new model instance when the $dia_sn doesn't exists
     * @return IntegralGift the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelByCode($giftCode, $new = false)
    {
        if (($model = IntegralGift::findOne(['gift_code' => $giftCode])) !== null) {
            return $model;
        } else {
            if($new) {
                $model = new IntegralGift();
                $model->gift_code = $giftCode;
                return $model;
            }
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
