<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bed".
 *
 * @property integer $id
 * @property string $name
 * @property string $bed_name
 * @property integer $breakfast
 * @property string $price
 * @property string $create_time
 * @property integer $room_id
 */
class Bed extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bed';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bed_name', 'price','name'], 'required'],
            [['breakfast','room_id'], 'integer'],
            [['create_time'], 'safe'],
            [['bed_name', 'price'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '床型名称',
            'bed_name' => '床型',
            'breakfast' => '早餐 1无早 2单早 3双早',
            'room_id' => '',
            'price' => '价格',
            'create_time' => 'Create Time',
        ];
    }
}
