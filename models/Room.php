<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "room".
 *
 * @property integer $id
 * @property string $room_name
 * @property string $area
 * @property string $img
 * @property integer $hotel_id
 * @property string $create_time
 */
class Room extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'room';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['room_name', 'area', 'img', 'hotel_id'], 'required'],
            [['hotel_id'], 'integer'],
            [['create_time'], 'safe'],
            [['room_name', 'area'], 'string', 'max' => 20],
            [['img'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'room_name' => '房型名称',
            'area' => '面积',
            'img' => '图片',
            'hotel_id' => '酒店ID',
            'create_time' => 'Create Time',
        ];
    }
}
