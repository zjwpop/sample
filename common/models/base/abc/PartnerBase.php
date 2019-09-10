<?php

namespace common\models\base\abc;

use Yii;

/**
 * This is the model class for table "abc_partner".
 *
 * @property int $id
 * @property string $company
 * @property string $prefix 前缀，如nmc
 * @property string $linker
 * @property string $tel
 * @property string $address
 * @property string $post_code
 * @property string $lng 经度
 * @property string $lat 纬度
 * @property int $status
 * @property int $create_time
 * @property int $update_time
 */
class PartnerBase extends \common\extensions\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'abc_partner';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lng', 'lat'], 'number'],
            [['status', 'create_time', 'update_time'], 'integer'],
            [['company', 'address'], 'string', 'max' => 64],
            [['prefix'], 'string', 'max' => 8],
            [['linker', 'tel'], 'string', 'max' => 32],
            [['post_code'], 'string', 'max' => 16],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company' => 'Company',
            'prefix' => '前缀，如nmc',
            'linker' => 'Linker',
            'tel' => 'Tel',
            'address' => 'Address',
            'post_code' => 'Post Code',
            'lng' => '经度',
            'lat' => '纬度',
            'status' => 'Status',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
