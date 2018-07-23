<?php

namespace frontend\modules\master\models;

use common\models\table\User;
use yii\data\ActiveDataProvider;

class Admin extends User {
	public function search($params) {
		$query = self::find()->where(['mst' => 1]);
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		return $dataProvider;
	}
}
