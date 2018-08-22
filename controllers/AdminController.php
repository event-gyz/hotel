<?php

namespace app\controllers;

use Yii;
use app\models\Admin;
use app\models\AdminSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use app\library\FileUpload;

/**
 * AdminController implements the CRUD actions for Admin model.
 */
class AdminController extends BController
{
    public $enableCsrfValidation = false;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['GET'],
                ],
            ],
        ];
    }

    /**
     * Lists all Admin models.
     * @return mixed
     */
    public function actionIndexAdmin()
    {
        $searchModel = new AdminSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Admin models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdminSearch();
        $search = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->search($search);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Admin model.
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
     * Creates a new Admin model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Admin();
        if ($model->load(Yii::$app->request->post())) {
            $imageUploadFile =   UploadedFile::getInstance($model,'img');
            if($imageUploadFile != null ){
                $saveUrl = $this->qiniu($imageUploadFile);
                $model->img = $saveUrl;
            }
            $model->save();
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    public function actionAdd(){
        $model = new Admin();
        $data = Yii::$app->request->post();
        $file = $_FILES['file'];
        if(empty($file)){
            echo '头像不能为空';
        }
        $picurl = $this->ceanza_upload("file");
        $arr = explode('/',$picurl);
        $picurl = '/uploads/'.end($arr);
        $picurl = str_replace('"','',$picurl);
        $model->img = $picurl;
        $model->username = $data['username'];
        $model->password = $data['password'];
        $model->type_of_cooperation = $data['type_of_cooperation'];
        $model->area = $data['area'];
        $model->save();
        return $this->redirect(['index']);
//        echo json_encode();
    }
    public function ceanza_upload($name = "file"){
        $up = new FileUpload;
        //设置属性(上传的位置， 大小， 类型， 名是是否要随机生成)
        $up -> set("path", "../web/uploads/");
        $up -> set("maxsize", 32000000);
        $up -> set("allowtype", array("gif", "png", "jpg","jpeg"));
        $up -> set("israndname", false);

        //使用对象中的upload方法， 就可以上传文件， 方法需要传一个上传表单的名子 pic, 如果成功返回true, 失败返回false
        if($up -> upload($name)) {
            return json_encode($up->getFileName());
        } else {
            die("文件上传失败");
            //$up->getErrorMsg()
        }
    }
    /**
     * Updates an existing Admin model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if (Yii::$app->request->post()) {
            $data = Yii::$app->request->post();
            $file = $_FILES['file'];
            if(!empty($file['name'])){
                $picurl = $this->ceanza_upload("file");
                $arr = explode('/',$picurl);
                $picurl = '/uploads/'.end($arr);
                $picurl = str_replace('"','',$picurl);
                $model->img = $picurl;
            }
            $model->username = $data['username'];
            $model->password = $data['password'];
            if(isset($data['area']) && !empty($data['area'])){
                $model->area = $data['area'];
            }

            $model->save();
            return $this->redirect(['update', 'id' => $model->uid]);

        } else {
            return $this->render('update', [
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
     * Deletes an existing Admin model.
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
     * Finds the Admin model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Admin the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Admin::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
