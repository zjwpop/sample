<?php
namespace common\models\table;

use Yii;
use common\models\base\UserBase;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;
use yii\behaviors\TimestampBehavior;
use common\validator\MobileValidator;

class User extends UserBase implements IdentityInterface
{
	const STATUS_ENABLE = 1;
	const STATUS_DISABLE = 0;

	public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'password' => '用户密码',
            'nick' => '昵称',
            'b_token' => 'B Token',
            'avatar' => '头像',
            'open_id' => 'Open ID',
            'mobile' => '手机号码',
            'email' => '用户邮箱',
            'status' => '状态',
            'role' => '是否管理员',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => ['create_time','update_time'],
                    self::EVENT_BEFORE_UPDATE => ['update_time'],
                ],
            ],
        ];
    }

    public function rules() {
		return array_merge(parent::rules(), [
			['mobile', MobileValidator::className()],
			['email', 'email'],
			['status', 'in', 'range' => [self::STATUS_ENABLE, self::STATUS_DISABLE]],
		]);
	}

    public static function statusMap($value = -1) {
		$map = [
			self::STATUS_ENABLE => '启用',
			self::STATUS_DISABLE => '禁用',
		];
		if ($value == -1) {
			return $map;
		}
		return ArrayHelper::getValue($map, $value, $value);
	}

    public static function findIdentity($id) {
		return self::findOne(['id' => $id]);
	}

	/**
	 * @inheritdoc
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @inheritdoc
	 */
	public function getAuthKey() {
		return null;
	}

	public function validateAuthKey($authKey) {
		return $this->getAuthKey() == $authKey;
	}

	/**
	 * 验证密码
	 *
	 * @param $password
	 * @return bool
	 */
	public function validatePassword($password) {
		return Yii::$app->getSecurity()->validatePassword($password, $this->password);
	}

	/**
	 * 加密密码
	 *
	 * @param $password
	 * @return string
	 * @throws \yii\base\Exception
	 */
	public function encryptPassword($password) {
		return Yii::$app->getSecurity()->generatePasswordHash($password);
	}

	/**
	 * 设置密码
	 *
	 * @param $password
	 * @throws \yii\base\Exception
	 */
	public function setPassword($password) {
		$this->password = $this->encryptPassword($password);
	}

	/////////////////////////;



    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['b_token' => $token]);
    }

    //这个就是我们进行yii\filters\auth\QueryParamAuth调用认证的函数，下面会说到。
    public function loginByAccessToken($accessToken, $type) {
        return static::findIdentityByAccessToken($token, $type);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

}
