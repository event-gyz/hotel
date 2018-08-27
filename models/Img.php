<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "img".
 *
 * @property integer $id
 * @property integer $type
 * @property integer $object_id
 * @property string $img_url
 * @property string $create_time
 */
class Img extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'img';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type','object_id'], 'integer'],
            [['img_url','object_id'], 'required'],
            [['create_time'], 'safe'],
            [['img_url'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type' => Yii::t('app', 'Type'),
            'img_url' => Yii::t('app', 'Img Url'),
            'create_time' => Yii::t('app', 'Create Time'),
        ];
    }
}
