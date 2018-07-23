<?php

namespace frontend\modules\master\models;

use common\models\table\User;
use yii\data\ActiveDataProvider;

class Admin extends User {
	public function search($params) {
		$query = self::find()->where(['mst' => 1])
			->andFilterWhere(['>','id',1])
			->andWhere(['<>','username','']);
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		return $dataProvider;
	}
}
