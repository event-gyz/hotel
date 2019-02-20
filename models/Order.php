<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property string $name
 * @property string $content_name
 * @property string $content_phone

 * @property integer $is_invoice
 * @property integer $invoice_type
 * @property string $invoice_title
 * @property string $invoice_address
 * @property string $invoice_name
 * @property string $invoice_phone
 * @property string $check_in_time
 * @property string $check_out_time
 * @property string $total_price
 * @property string $hotel_id
 * @property string $room_id
 * @property string $bed_id
 * @property integer $is_pinfang
 * @property integer $num
 * @property integer $nights
 * @property integer $pay_status
 * @property string $create_time
 * @property integer $sex
 * @property integer $order_no
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            [['name', 'content_name', 'content_phone', 'check_in_time', 'check_out_time', 'total_price', 'hotel_id', 'room_id','bed_id','create_time','num','nights'], 'required'],
//            [['name', 'content_name', 'content_phone'], 'string', 'max' => 255],
//            [['total_price'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '入住人姓名',
            'content_name' => '联系人姓名',
            'content_phone' => '联系人电话',
            'check_in_time' => '入住时间',
            'check_out_time' => '离店时间',
            'total_price' => '订单金额',
            'hotel_id' => '酒店ID',
            'room_id' => '房型ID',
            'create_time' => '下单时间',
            'pay_status' => '支付状态',
            'is_pinfang' => '是否拼房',
            'sex' => '性别',
            'num'=>'房间数量',
            'order_no'=>'订单号',
        ];
    }
}
