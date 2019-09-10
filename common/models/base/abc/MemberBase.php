<?php

namespace common\models\base\abc;

use Yii;

/**
 * This is the model class for table "abc_member".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $nick
 * @property string $token
 * @property string $auth_key
 * @property string $avatar
 * @property string $open_id
 * @property string $mobile
 * @property string $email
 * @property int $status
 * @property string $last_login_ip
 * @property int $last_login_time
 * @property int $create_time
 */
class MemberBase extends \common\extensions\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'abc_member';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'last_login_time', 'create_time'], 'integer'],
            [['username', 'password', 'token', 'auth_key', 'avatar', 'open_id'], 'string', 'max' => 64],
            [['nick', 'email'], 'string', 'max' => 32],
            [['mobile', 'last_login_ip'], 'string', 'max' => 16],
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
            'password' => 'Password',
            'nick' => 'Nick',
            'token' => 'Token',
            'auth_key' => 'Auth Key',
            'avatar' => 'Avatar',
            'open_id' => 'Open ID',
            'mobile' => 'Mobile',
            'email' => 'Email',
            'status' => 'Status',
            'last_login_ip' => 'Last Login Ip',
            'last_login_time' => 'Last Login Time',
            'create_time' => 'Create Time',
        ];
    }
}
