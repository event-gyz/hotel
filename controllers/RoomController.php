<?php

namespace app\controllers;

use Yii;
use app\models\Room;
use app\models\RoomSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * RoomController implements the CRUD actions for Room model.
 */
class RoomController extends Controller
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
                    'delete' => ['POST','GET'],
                ],
            ],
        ];
    }

    /**
     * Lists all Room models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RoomSearch();
        if($_GET['hotel_id']){
            $params = ['RoomSearch'=>['hotel_id'=>$_GET['hotel_id']]];
        }else{
            $params = [];
        }
        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Room model.
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
     * Creates a new Room model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Room();

//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        } else {
//            return $this->render('create', [
//                'model' => $model,
//            ]);
//        }
        if ($model->load(Yii::$app->request->post())) {
            $imageUploadFile =   UploadedFile::getInstance($model,'img');
//            echo '<pre>';
//            print_r($_FILES);exit;
            if($imageUploadFile != null ){
                $saveUrl = $this->qiniu($imageUploadFile);
                $model->img = $saveUrl;
            }
            $model->save();

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    public function qiniu($imageUploadFile){
        $typeUrl = '/uploads/';
        $saveUrl = $this->saveImage($imageUploadFile, '', '', $typeUrl);
        return $saveUrl;
    }
    public function saveImage($imageUploadInstance, $width, $height, $type)
    {
        if ($imageUploadInstance == null)
        {
            return null;
        }
        $imageFileExt = strtolower($imageUploadInstance->getExtension());
        $save_path    = Yii::$app->getBasePath().'/web'.$type;
        if (!file_exists($save_path))
        {
            mkdir($save_path, 0777, true);
        }
        $ymd = date("Y/md");
        $save_path .= $ymd . '/';
        if (!file_exists($save_path))
        {
            mkdir($save_path, 0777, true);
        }
        $img_prefix    = date("YmdHis") . '_' . rand(10000, 99999);
        $imageFileName = $img_prefix . '.' . $imageFileExt;
        $save_path .= $imageFileName;
        $imageUploadInstance->saveAs($save_path);
        //$obj = Image::thumbnail($save_path, $width, $height)->save($save_path);
        return  $type.$ymd . '/'. $imageFileName;
    }
    /**
     * Updates an existing Room model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $data = Yii::$app->request->post()['Room'];
//            print_r($data);exit;
            $imageUploadFile =   UploadedFile::getInstance($model,'img');
            if($imageUploadFile != null ){
                $saveUrl = $this->qiniu($imageUploadFile);
                $model->img = $saveUrl;
            }
            $model->room_name = $data['room_name'];
            $model->area = $data['area'];
//            $model->hotel_id = $data['hotel_id'];
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        } else {
//            return $this->render('update', [
//                'model' => $model,
//            ]);
//        }
    }

    /**
     * Deletes an existing Room model.
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
     * Finds the Room model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Room the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Room::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
