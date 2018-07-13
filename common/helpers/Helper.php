<?php

namespace common\helpers;
use Yii;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\log\FileTarget;

class Helper {
	public static function is_json($string) {
		json_decode($string);
		return (json_last_error() == JSON_ERROR_NONE);
	}

	public static function setToken(){
		$str=md5(mt_rand());
		return substr($str,20).substr($str,0,20);
	}

	public static function dfv($val,$defult=''){
		if(!empty($val)){return $val;}
		return $defult;
	}
}
