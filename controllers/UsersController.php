<?php

namespace app\controllers;

use app\models\Member;
use app\models\User;
use Yii;
use app\models\Users;
use app\models\UsersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UsersController implements the CRUD actions for Users model.
 */
class UsersController extends BController
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
     * Lists all Users models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UsersSearch();
        $params = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->search($params);

        $agency_id = \Yii::$app->user->identity->id;

        $statistics = $this->getUserStatistics($agency_id);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'statistice' =>$statistics,
        ]);
    }


    public function getUserStatistics($agency_id=0){
        $time = date("Y-m-d H:i:s", strtotime("-7 day"));
        $time3 = date("Y-m-d H:i:s", strtotime("-3 month"));
        $result['all'] = 0;
        $result['new'] = 0;
        $result['ative'] = 0;
        if(empty($agency_id)){
            $result['all'] = Users::find()->joinWith(['member'])->asArray()->count();
            $result['new'] = Users::find()->joinWith(['member'])->where(['>','member.create_time',$time])->asArray()->count();
            $result['ative'] = Users::find()->joinWith(['member'])->where(['>','member.last_login_time',$time3])->asArray()->count();
        }else{
            $result['all'] = Users::find()->joinWith(['member'])->where(['agency_id'=>$agency_id])->asArray()->count();
            $result['new'] = Users::find()->joinWith(['member'])->where(['agency_id'=>$agency_id])->andWhere(['>','member.create_time',$time])->asArray()->count();
            $result['ative'] = Users::find()->joinWith(['member'])->where(['agency_id'=>$agency_id])->andWhere(['>','member.last_login_time',$time3])->asArray()->count();

        }
        return $result;
    }
    /**
     * Displays a single Users model.
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
     * Creates a new Users model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Users();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->uid]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Users model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->uid]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Users model.
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
     * Finds the Users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Users::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }



    private function handleTypeIndex($num){
        if($num<30){
            return '弱';
        }else if($num<60){
            return '中';
        }else{
            return '强';
        }
    }
}
