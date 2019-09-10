<?php

namespace common\models\table\abc;

use common\models\base\abc\UserBase;
use common\validator\MobileValidator;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

class User extends UserBase implements IdentityInterface
{
	const STATUS_ENABLE = 1;
	const STATUS_DISABLE = 0;

	public function behaviors()
	{
		return [
			[
				'class' => TimestampBehavior::className(),
				'attributes' => [
					self::EVENT_BEFORE_INSERT => ['create_time', 'update_time'],
					self::EVENT_BEFORE_UPDATE => ['update_time'],
				],
			],
		];
	}

	public function rules()
	{
		return array_merge(parent::rules(), [
			['mobile', MobileValidator::className()],
			['email', 'email'],
			['status', 'in', 'range' => [self::STATUS_ENABLE, self::STATUS_DISABLE]],
		]);
	}

	public static function statusMap($value = -1)
	{
		$map = [
			self::STATUS_ENABLE => '启用',
			self::STATUS_DISABLE => '禁用',
		];
		if ($value == -1) {
			return $map;
		}
		return ArrayHelper::getValue($map, $value, $value);
	}

	public static function findIdentity($id)
	{
		return self::findOne(['id' => $id]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getAuthKey()
	{
		return null;
	}

	public function validateAuthKey($authKey)
	{
		return $this->getAuthKey() == $authKey;
	}

	/**
	 * 验证密码
	 *
	 * @param $password
	 * @return bool
	 */
	public function validatePassword($password)
	{
		return Yii::$app->getSecurity()->validatePassword($password, $this->password);
	}

	/**
	 * 加密密码
	 *
	 * @param $password
	 * @return string
	 * @throws \yii\base\Exception
	 */
	public function encryptPassword($password)
	{
		return Yii::$app->getSecurity()->generatePasswordHash($password);
	}

	/**
	 * 设置密码
	 *
	 * @param $password
	 * @throws \yii\base\Exception
	 */
	public function setPassword($password)
	{
		$this->password = $this->encryptPassword($password);
	}

	/////////////////////////;

	/**
	 * {@inheritdoc}
	 */
	public static function findIdentityByAccessToken($token, $type = null)
	{
		return static::findOne(['token' => $token]);
	}

	//这个就是我们进行yii\filters\auth\QueryParamAuth调用认证的函数，下面会说到。
	public function loginByAccessToken($token, $type)
	{
		return static::findIdentityByAccessToken($token, $type);
	}

	/**
	 * Finds user by username
	 *
	 * @param  string      $username
	 * @return static|null
	 */
	public static function findByUsername($username)
	{
		return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
	}

	public function getPartner()
	{
		return $this->hasOne(Partner::className(), ['id' => 'partner_id']);
	}
}
