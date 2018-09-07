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
 * @property string $email
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
 * @property integer $num
 * @property integer $nights
 * @property string $create_time
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
            [['name', 'content_name', 'content_phone', 'check_in_time', 'check_out_time', 'total_price', 'hotel_id', 'room_id','bed_id'], 'required'],
            [['name', 'content_name', 'content_phone'], 'string', 'max' => 255],
            [['total_price'], 'string', 'max' => 20],
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
            'email' => '邮箱',
            'is_invoice' => '是否需要发票',
            'invoice_type' => 'Invoice Type',
            'invoice_title' => 'Invoice Title',
            'invoice_address' => 'Invoice Address',
            'invoice_name' => 'Invoice Name',
            'invoice_phone' => 'Invoice Phone',
            'check_in_time' => '入住时间',
            'check_out_time' => '离店时间',
            'total_price' => '订单金额',
            'hotel_id' => '酒店ID',
            'room_id' => '房型ID',
            'create_time' => 'Create Time',
        ];
    }
}
