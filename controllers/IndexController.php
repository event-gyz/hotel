<?php

/**
 * Created by PhpStorm.
 * User: guanyazhuo
 * Date: 2018/8/25
 * Time: 下午2:50
 */
namespace app\controllers;

use Yii;
use  yii\web\Session;
use app\models\Room;
use app\models\Bed;
use app\models\Hotel;
use app\models\HotelSearch;
use app\models\Order;
use yii\web\Controller;
use yii\base\Exception;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Wx;

/**
 * RoomController implements the CRUD actions for Room model.
 */
class IndexController extends Controller
{
    public $layout=false;


    public $appId = 'wx3050c26206b465f3';
    public $appSecret = '90c13c1da9fef4b831f17d7b19b4df12';
    /**
     * @inheritdoc
     */

    public function response($response = [])
    {
        header("Content-type: application/json;charset=utf-8");
        echo json_encode($response,JSON_UNESCAPED_UNICODE );
        exit;
    }
    public $_return = ['errorno' => 0, 'msg' => ''];


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
     * Lists all Room models.
     * @return mixed
     */
    public function actionIndex()
    {
        $session = Yii::$app->session;

        if(!isset($session['open_id']) || ($session['expire_time'] < time())){
            header("Location:/index/get-openid");
        }
        return $this->render('index');
    }

    /**
     * Lists all Room models.
     * @return mixed
     */
    public function actionList()
    {
        $session = Yii::$app->session;
        if(!isset($session['open_id']) || ($session['expire_time'] < time())){
            header("Location:/index/get-openid");
        }
        $model = new Hotel();
        $hotel_list = $model->find()->asArray()->all();
        foreach($hotel_list as &$value){
            $value['min_price'] = $this->getMinPrice($value['id']);
        }
        return $this->render('list', [
            'hotel_list' => $hotel_list
        ]);
    }

    /**
     * Lists all Room models.
     * @return mixed
     */
    public function actionDetail()
    {
        $model = new Hotel();
        $hotel_id = Yii::$app->request->get('hotelId');
        $re = $model->find()->where(['id'=>$hotel_id])->asArray()->one();
        $detail = $this->getRoomAndBed($hotel_id);
        return $this->render('detail', [
            'hotel_info' => $re,
            'detail' => $detail,
        ]);
    }

    /**
     * Lists all Room models.
     * @return mixed
     */
    public function actionPay()
    {
        if(strtotime($_GET['startDate']) < strtotime(date('Y-m-d',time()))){
            header("Location:/index");
        }
        $model = new Hotel();
        $bedModel = new Bed();
        $roomModel = new Room();
        $hotel_id = Yii::$app->request->get('hotelId');
        $bed_id = Yii::$app->request->get('bedId');
        $re = $model->find()->where(['id'=>$hotel_id])->asArray()->one();
        $bed_info = $bedModel->find()->where(['id'=>$bed_id])->asArray()->one();
        $room_info = $roomModel->find()->where(['id'=>$bed_info['room_id']])->asArray()->one();
        return $this->render('pay', [
            'hotel_info' => $re,
            'bed_info' => $bed_info,
            'room_info' => $room_info,
        ]);
    }

    public function actionPayPage(){
        $model = new Hotel();
        $orderModel = new Order();
        $wxJsApiData = '';
        $orderId = Yii::$app->request->get('orderId');
        $orderInfo = $orderModel->find()->where(['id'=>$orderId])->asArray()->one();
        $hotelInfo = $model->find()->where(['id'=>$orderInfo['hotel_id']])->asArray()->one();
        $session = Yii::$app->session;
        $open_id = $session['open_id'];
        $wxJsApiData = $this->wxpay($open_id,'房费',$orderInfo['total_price'],$orderInfo['id'],$orderInfo['order_no']);
        return $this->render('paypage', [
            'hotel_info' => $hotelInfo,
            'order_info' =>$orderInfo,
            'wxJsApiData'=> json_encode($wxJsApiData, JSON_UNESCAPED_UNICODE),

        ]);
    }
    public function actionPayOrder(){
        $model = new Order();
        $bedModel = new Bed();
        $data = Yii::$app->request->post();
        if (empty($data['check_in_time'])) {
            $this->_return['errorno'] = -1;
            $this->_return['msg'] = '入住时间不能为空';
            $this->response($this->_return);
        }

        if (empty($data['check_out_time'])) {
            $this->_return['errorno'] = -1;
            $this->_return['msg'] = '离店时间不能为空';
            $this->response($this->_return);
        }

        if (empty($data['name'])) {
            $this->_return['errorno'] = -1;
            $this->_return['msg'] = '入住人不能为空';
            $this->response($this->_return);
        }
        if (empty($data['content_name'])) {
            $this->_return['errorno'] = -1;
            $this->_return['msg'] = '联系人不能为空';
            $this->response($this->_return);
        }
        if(!empty($data['is_pinfang']) && empty($data['sex'])){
            $this->_return['errorno'] = -1;
            $this->_return['msg'] = '请选择性别';
            $this->response($this->_return);
        }
        if (empty($data['content_phone'])) {
            $this->_return['errorno'] = -1;
            $this->_return['msg'] = '联系电话不能为空';
            $this->response($this->_return);
        }
        if(strlen($data['content_phone']) < 11){
            $this->_return['errorno'] = -1;
            $this->_return['msg'] = '联系电话格式不正确';
            $this->response($this->_return);
        }
        $bed = $bedModel->find()->where(['id'=>$data['bed_id']])->asArray()->one();
        $data['create_time'] = date('Y-m-d H:i:s',time());
        $data['room_id'] = $bed['room_id'];
        $data['check_in_time']  = $data['check_in_time'].' 00:00:00';
        $data['check_out_time'] = $data['check_out_time'].' 00:00:00';
        $data['nights'] = (strtotime($data['check_out_time'])-strtotime($data['check_in_time']))/86400;
        $data['total_price'] = $data['nights'] * $data['num'] * $bed['price'];
        $data['order_no'] = date('YmdHis').rand(1000, 9999);
        $transaction = Yii::$app->db->beginTransaction();
        try {
//            $modelData['Order'] = $data;

//            $model->load($modelData);

            unset($data['_csrf']);
            $db = \Yii::$app->db->createCommand();
            $db->insert('order' , $data )->execute();
            $id = \Yii::$app->db->getLastInsertID();
//            $model->save();
            $transaction->commit();
            $this->_return['errorno'] = 1;
            $this->_return['msg']     = '请求成功';
            $this->_return['data']    = $id;
            $this->response($this->_return);
        } catch (Exception $e) {
            $transaction->rollBack();
            $this->_return['errorno'] = -1;
            $this->_return['msg'] = '保存失败';
            $this->_return['error'] = $e->getMessage();
            $this->response($this->_return);
        }
    }
    public function wxpay($openid,$body,$money,$order_id,$order_no){
        $obj = array();
        $obj['appid']           = $this->appId; //小程序appid
        $obj['mch_id']         	= '1513357261'; //商户号
        $obj['body']        	= $body;
        $obj['out_trade_no']	= $order_no;
        $obj['total_fee']       = $money*100;
//        $obj['total_fee']       = 1;
        $obj['spbill_create_ip']= $_SERVER['REMOTE_ADDR'];
        $obj['notify_url']      = 'http://fang.xxxxzzzz.xyz/index/change-status?order_id='.$order_id;

        $obj['trade_type']      = "JSAPI";  //小程序取值：JSAPI，
        $obj['openid']          = $openid;

        $url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
        $weAppPay = new Wx();
        $data = $weAppPay->wxpay($url, $obj, false);
        $res = $weAppPay->xmlToArray($data);
//        file_put_contents('./php.log', json_encode($res). "\r\n", FILE_APPEND);
//        return $res;
        $prepay_id = $res["prepay_id"];
        $obj2 = array();
        $obj2['appId']           = $this->appId;//小程序appid
        $obj2['package']        	= "prepay_id=".$prepay_id;
        $data = $weAppPay->wxpaysign($obj2);
        $data = array_merge($data, array("prepay_id"=>$prepay_id, "trade_no"=>$obj['out_trade_no']));
        return $data;
    }

    public function actionChangeStatus(){
        $data = Yii::$app->request->get();
        $order_id = $data['order_id'];
        Order::updateAll(['pay_status'=>1],['id'=>$order_id]);
        header("Location:/index/list");
    }
    protected function getRoom($hotel_id){
        $room = new Room();
        $res = $room->find()->where(['hotel_id'=>$hotel_id])->asArray()->all();
        return $res;
    }
    protected function getBed($room_id){
        $bed = new Bed();
        $res = $bed->find()->where(['room_id'=>$room_id])->asArray()->all();
        return $res;
    }


    public function actionGetOpenid()
    {
        $code = Yii::$app->request->get('code');
        $appid = $this->appId;
        $secret = $this->appSecret;
        if(empty($code)){
            $REDIRECT_URI='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            $scope='snsapi_userinfo';
            $url='https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.urlencode($REDIRECT_URI).'&response_type=code&scope='.$scope.'&state=wx'.'#wechat_redirect';
            header("Location:".$url);
        }

        $get_token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appid.'&secret='.$secret.'&code='.$code.'&grant_type=authorization_code';
        $res = file_get_contents($get_token_url);
        $json_obj = json_decode($res,true);
        $openid = $json_obj['openid'];
//        print_r($session['open_id']);exit;
        //根据openid和access_token查询用户信息
//        $access_token = $json_obj['access_token'];
//        $openid = $json_obj['openid'];
//        $get_user_info_url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';
//        $res = file_get_contents($get_user_info_url);
//        //解析json
//        $user_obj = json_decode($res,true);
        if(!empty($openid)){
            $session = Yii::$app->session;

            $session['expire_time']= time() + 300;
            $session['open_id'] = $openid;

            header("Location:/index");
        }else{
            print_r($json_obj);exit;
        }
    }
    public function getWxSession($appid,$secret,$code,$grant_type = 'authorization_code'){
        $req_url =
            'https://api.weixin.qq.com/sns/jscode2session?appid='.$appid
            .'&secret='.$secret.'&js_code=' .$code
            .'&grant_type='.$grant_type;
        $json_data = file_get_contents($req_url);
        $arrData = json_decode($json_data,true);
        return $arrData;
    }

    protected function getRoomAndBed($hotel_id){
        $room = new Room();
        $bed = new Bed();
        $room_list = $room->find()->where(['hotel_id'=>$hotel_id])->asArray()->all();
        foreach($room_list as $key=>$value){
            $res = $bed->find()->where(['room_id'=>$value['id']])->asArray()->all();
            $room_list[$key]['bed_list'] = $res;
            $min_price = min(array_column($res,'price'));
            $room_list[$key]['min_price'] = $min_price ;
        }

//        echo '<pre>';print_r($room_list);exit;
        return $room_list;
    }

    protected  function getMinPrice($hotel_id){
        $room = new Room();
        $bed = new Bed();
        $room_list = $room->find()->where(['hotel_id'=>$hotel_id])->asArray()->all();
        $room_ids = implode(',',array_column($room_list,'id'));
        $res = $bed->find()->where(['in','room_id',$room_ids])->orderBy(['price' => SORT_ASC])->asArray()->one();
        return $res['price'];
    }
}