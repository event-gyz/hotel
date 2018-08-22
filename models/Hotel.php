<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hotel".
 *
 * @property integer $id
 * @property string $hotel_name
 * @property string $hotel_address
 * @property integer $find_time
 * @property string $img
 * @property string $create_time
 */
class Hotel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hotel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'hotel_name', 'find_time', 'img'], 'required'],
            [['id', 'find_time'], 'integer'],
            [['img'], 'string'],
            [['create_time'], 'safe'],
            [['hotel_name'], 'string', 'max' => 50],
            [['hotel_address'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'hotel_name' => '酒店名称',
            'hotel_address' => '酒店地址',
            'find_time' => '开业时间',
            'img' => '图片',
            'create_time' => 'Create Time',
        ];
    }
}
