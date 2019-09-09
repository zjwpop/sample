<?php

namespace common\models\base\abc;

use Yii;

/**
 * This is the model class for table "abc_partner".
 *
 * @property int $id
 * @property string $username
 * @property string $mobile
 * @property string $email
 * @property string $password
 * @property string $token
 * @property string $auth_key
 * @property string $open_id
 * @property int $status
 * @property string $company
 * @property string $prefix 前缀，如nmc
 * @property string $nick
 * @property string $avatar
 * @property string $last_login_ip
 * @property int $last_login_time
 * @property int $create_time
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
            [['status', 'last_login_time', 'create_time'], 'integer'],
            [['username', 'password', 'token', 'auth_key', 'open_id', 'company', 'avatar'], 'string', 'max' => 64],
            [['mobile', 'last_login_ip'], 'string', 'max' => 16],
            [['email', 'nick'], 'string', 'max' => 32],
            [['prefix'], 'string', 'max' => 8],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'mobile' => 'Mobile',
            'email' => 'Email',
            'password' => 'Password',
            'token' => 'Token',
            'auth_key' => 'Auth Key',
            'open_id' => 'Open ID',
            'status' => 'Status',
            'company' => 'Company',
            'prefix' => '前缀，如nmc',
            'nick' => 'Nick',
            'avatar' => 'Avatar',
            'last_login_ip' => 'Last Login Ip',
            'last_login_time' => 'Last Login Time',
            'create_time' => 'Create Time',
        ];
    }
}
