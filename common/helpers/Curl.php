<?php

namespace common\helpers;

use Yii;

class Curl
{
	static $curl = null;

	public static function getUrl($route)
	{
		$host = Yii::$app->params['capi_host'];
		return $host . $route;
	}

	public static function curl($url, $data = [], $method = 'get', $params = [], $debug = false)
	{
		if (!Curl::$curl) {
			Curl::$curl = curl_init();
		}
		$ch = Curl::$curl;

		if ($method == 'get' && !empty($data)) {
			$params = $data;
		}
		if ($params) {
			$p = parse_url($url);
			if (!empty($p['query'])) {
				parse_str($p['query'], $query_data);
				if (is_array($query_data)) {
					$params = $params + $query_data;
				}
			}
			$url = '';
			if (isset($p['scheme'])) {
				$url .= $p['scheme'] . '://';
			}
			if (isset($p['host'])) {
				$url .= $p['host'];
			}
			if (isset($p['port'])) {
				$url .= ':' . $p['port'];
			}
			if (isset($p['path'])) {
				$url .= $p['path'];
			}
			$url .= '?' . http_build_query($params);
		}

		$options = [
			CURLOPT_URL => $url,
			CURLOPT_CUSTOMREQUEST => strtoupper($method),
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_CONNECTTIMEOUT => 5,
			CURLOPT_SSL_VERIFYPEER => 0,
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_USERAGENT => ''
		];
		if (isset($_SERVER['HTTP_USER_AGENT']) && $_SERVER['HTTP_USER_AGENT'] == 'NMC_BETA') {
			$options[CURLOPT_USERAGENT] = $_SERVER['HTTP_USER_AGENT'];
		}
		if ($method == 'post' && $data) {
			$options[CURLOPT_POSTFIELDS] = $data;
		}
		if ($debug) {
			echo '$options<pre>';
			print_r($options);
			echo '</pre><hr>';
		}
		curl_setopt_array($ch, $options);
		$response = curl_exec($ch);

		if ($response === false) {
			$result = [
				'errno' => curl_errno($ch),
				'errmsg' => curl_error($ch),
			];
			return $result;
		}

		$result = json_decode($response, true);
		if (is_null($result)) {
			return [
				'errno' => 500,
				'errmsg' => 'parse to json error',
				'response' => $response,
			];
		}

		return $result;
	}

	public static function get($route, $data = [])
	{
		$url = self::getUrl($route);
//        var_dump($url);
//        exit();
		return self::curl($url, $data);
	}

	public static function post($route, $data = [])
	{
		$url = self::getUrl($route);
		return self::curl($url, $data, 'post');
	}
}
