<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bed".
 *
 * @property integer $id
 * @property string $bed_name
 * @property integer $breakfast
 * @property string $price
 * @property string $create_time
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
            [['bed_name', 'price'], 'required'],
            [['breakfast'], 'integer'],
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
            'bed_name' => '床型名称',
            'breakfast' => '早餐情况',
            'price' => '价格',
            'create_time' => 'Create Time',
        ];
    }
}
