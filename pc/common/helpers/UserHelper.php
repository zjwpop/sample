<?php

namespace backend\common\helpers;

use Yii;

class UserHelper
{
    /**
     * @var yii\db\ActiveRecord|string 用户类，实例或类名
     */
    public $userClass;

    /**
     * @var string 用户表主键
     */
    public $userIdField = 'id';

    /**
     * @var string 用户名字段
     */
    public $usernameField = 'username';

    /**
     * @return self
     */
    public static function get()
    {
        return Yii::$container->get('UserHelper');
    }

    /**
     * 获取用户实例，默认返回当前登录的用户实例
     *
     * @param int|string $userId
     * @return yii\db\ActiveRecord|null
     */
    public static function getUserInstance($userId = 0)
    {
        if ($userId == 0) {
            return Yii::$app->user->identity;
        } else {
            $userHelper = self::get();
            return call_user_func([$userHelper->userClass, 'find'])
                ->where([$userHelper->userIdField => $userId])
                ->limit(1)
                ->one();
        }
    }

    /**
     * 获取用户名，默认返回当前登录用户的用户名
     *
     * @param int $userId
     * @param null $default
     * @return bool|null|string
     */
    public static function getUserName($userId = -1, $default = null)
    {
        $userHelper = self::get();
        if ($userId == -1 && !Yii::$app->user->isGuest) {
            return self::getUserInstance()->{$userHelper->usernameField};
        } else {
            $username = call_user_func([$userHelper->userClass, 'find'])
                ->select([$userHelper->usernameField])
                ->where([$userHelper->userIdField => $userId])
                ->limit(1)
                ->scalar();
            if ($username) {
                return $username;
            }
        }
        return $default;
    }
}
