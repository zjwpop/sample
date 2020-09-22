<?php

namespace common\helpers;

use common\models\table\Seo;
use Yii;
use yii\helpers\ArrayHelper;
use yii\log\FileTarget;

class Helper
{
	public static $curl = null;

	/**
	 * 获取参数
	 *
	 * @param $key
	 * @param $default
	 * @return array|string
	 */
	public static function getParam($key, $default = null)
	{
		return ArrayHelper::getValue(Yii::$app->params, $key, $default);
	}

	/**
	 * 设置参数
	 *
	 * @param $key
	 * @param $value
	 */
	public static function setParam($key, $value)
	{
		Yii::$app->params[$key] = $value;
	}

	/**
	 * redis读取数据
	 * @param $key
	 * @param $default
	 * @return mixed|null
	 * @author luotaipeng
	 */
	public static function redis_get($key, $default = null)
	{
		/** @var \yii\redis\Connection $redis */
		$redis = Yii::$app->get('redis');
		$prefix = self::getParam('redis_key_prefix');
		if ($prefix) {
			$key = $prefix.$key;
		}
		$value = $redis->get($key);
		if ($value === null) {
			return $default;
		}
		if (is_string($value) && !is_numeric($value)) {
			$unserialize_value = @unserialize($value);
			if ($unserialize_value !== false) {
				return $unserialize_value;
			}
		}
		return $value;
	}

	/**
	 * redis写入数据
	 * @author luotaipeng
	 *
	 * @param $key
	 * @param $value
	 * @param $expire
	 * @return bool
	 */
	public static function redis_set($key, $value, $expire = null)
	{
		/** @var \yii\redis\Connection $redis */
		$redis = Yii::$app->get('redis');
		if (is_null($expire)) {
			$expire = self::getParam('redis_key_timeout');
		}
		if (is_null($expire) || !is_int($expire)) {
			$expire = 3600;
		}
		$prefix = self::getParam('redis_key_prefix');
		if ($prefix) {
			$key = $prefix.$key;
		}
		if (is_bool($value)) {
			$value = intval($value);
		}
		if (!is_scalar($value)) {
			$value = serialize($value);
		}
		return $redis->executeCommand('SET', [$key, $value, 'EX', $expire]);
	}

	/**
	 * redis删除数据
	 * @author luotaipeng
	 *
	 * @param $key
	 * @return bool
	 */
	public static function redis_del($key)
	{
		/** @var \yii\redis\Connection $redis */
		$redis = Yii::$app->get('redis');
		$prefix = self::getParam('redis_key_prefix');
		if ($prefix) {
			$key = $prefix.$key;
		}
		return $redis->executeCommand('DEL', [$key]);
	}

	/**
	 * 写日志文件
	 * @author luotaipeng
	 * @param $content
	 * @param  string                           $logName
	 * @throws \yii\base\InvalidConfigException
	 * @throws \yii\log\LogRuntimeException
	 */
	public static function fLogs($content, $logName = 'log.log')
	{
		$time = microtime(true);
		$log = new FileTarget();
		$log->logFile = Yii::$app->getRuntimePath().'/logs/'.$logName;
		$log->messages[] = [$content, 1, 'application', $time];
		$log->export();
	}

	/**
	 * 设置SEO变量
	 * @author luotaipeng
	 * @param $key
	 * @param $value
	 */
	public static function set_seo_var($key, $value)
	{
		ArrayHelper::setValue(Yii::$app->params, 'seo_vars.'.$key, $value);
	}

	/**
	 * 更新当前页面SEO信息
	 * @author luotaipeng
	 */
	public static function set_seo_info()
	{
		$result = [
			'errno' => 0,
			'errmsg' => '',
			'data' => [],
		];

		if (!empty($_GET['disable_seo_info'])) {
			return $result;
		}

		$app_id = Yii::$app->id;
		$app_map = [
			'pc' => 0,
			'm' => 1,
		];
		if (!isset($app_map[$app_id])) {
			return $result;
		}
		$web = $app_map[$app_id];

		// 查询SEO信息
		$seo_info = self::redis_get('seo_info_'.$web);
		if (self::getParam('disable_seo_cache') || !is_array($seo_info) || !empty($_GET['refresh_seo_info'])) {
			$seo_info = Seo::find()
				->where([
					'web' => $web,
					'enabled' => 1,
				])
				->select([
					'id',
					'web',
					'uri',
					'title',
					'keywords',
					'description',
				])
				->indexBy('uri')
				->asArray()
				->all();
			self::redis_set('seo_info_'.$web, $seo_info);
		}

		// 设置SEO信息
		$route = Yii::$app->controller->route;
		$route = substr($route, strlen(Yii::$app->controller->module->id) + 1);
		$result['route'] = $route;
		if (isset($seo_info[$route])) {
			$meta_list = ['title', 'keywords', 'description'];
			$meta_info = $seo_info[$route];

			$seo_vars = self::getParam('seo_vars');
			if (is_array($seo_vars)) {
				foreach ($seo_vars as $k => $v) {
					if ($v && in_array($k, $meta_list)) {
						$meta_info[$k] = $v;
					}
				}
				foreach ($meta_info as $k => $v) {
					$meta_info[$k] = str_replace(array_keys($seo_vars), array_values($seo_vars), $v);
					if (!self::getParam('show_seo_placeholder') && empty($_GET['show_seo_placeholder']) && !YII_DEBUG) {
						$meta_info[$k] = preg_replace('/{[^(\})]*}/', '', $meta_info[$k]);
					}
				}
			}

			foreach ($meta_list as $meta) {
				if (!$meta_info[$meta]) {
					continue;
				}
				if ($meta == 'title') {
					Yii::$app->view->title = $meta_info[$meta];
				} else {
					Yii::$app->view->registerMetaTag([
						'name' => $meta,
						'content' => $meta_info[$meta],
					]);
				}
				$result['data'][] = $meta;
			}
		}

		return $result;
	}

	/**
	 * @param $value
	 * @return string|array
	 */
	public static function unifyLimiter($value)
	{
		return str_replace([' ', '　', '，', '、', "\n"], ',', $value);
	}

	/**
	 * 设置输出内容格式为json
	 * @author luotaipeng
	 */
	public static function json_output($data = null, $exit = true)
	{
		if (!$data) {
			Yii::$app->response->format = 'json';
			return;
		}
		$data = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
		if (!$exit) {
			return $data;
		}
		echo $data;
		exit(0);
	}

	/**
	 * CURL发送http请求
	 * @return array|string|object
	 * @author luotaipeng
	 */
	public static function curl($url, $data = [], $method = 'get', $params = [], $debug = false)
	{
		if (!self::$curl) {
			self::$curl = curl_init();
		}
		$ch = self::$curl;

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
				$url .= $p['scheme'].'://';
			}
			if (isset($p['host'])) {
				$url .= $p['host'];
			}
			if (isset($p['path'])) {
				$url .= $p['path'];
			}
			$url .= '?'.http_build_query($params);
		}

		$options = [
			CURLOPT_URL => $url,
			CURLOPT_CUSTOMREQUEST => strtoupper($method),
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_CONNECTTIMEOUT => 5,
			CURLOPT_SSL_VERIFYPEER => 0,
			CURLOPT_SSL_VERIFYHOST => 0,
		];
		if (isset($_SERVER['HTTP_USER_AGENT']) && $_SERVER['HTTP_USER_AGENT'] == 'NMC_BETA') {
			$options[CURLOPT_USERAGENT] = $_SERVER['HTTP_USER_AGENT'];
		}
		if ($method == 'post' && $data) {
			$options[CURLOPT_POSTFIELDS] = $data;
			if (!is_array($data)) {
				$options[CURLOPT_HTTPHEADER] = ['Content-Type: text/plain'];
			}
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

	/**
	 * 设置Header CORS
	 * @author luotaipeng
	 */
	public static function set_cors()
	{
		$headers = Yii::$app->response->headers;
		$headers->set('Access-Control-Allow-Origin', 'http://www.chedidi.com');
		$headers->set('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept, Connection, User-Agent, Cookie');
		$headers->set('Access-Control-Allow-Credentials', 'true');

		$referer = null;
		$http_referer = null;
		if (!empty($_SERVER['HTTP_REFERER'])) {
			$http_referer = $_SERVER['HTTP_REFERER'];
		}
		if (!$http_referer && !empty($_SERVER['HTTP_ORIGIN'])) {
			$http_referer = $_SERVER['HTTP_ORIGIN'];
		}
		if ($http_referer) {
			$referer = parse_url($http_referer);
			$referer = $referer + ['host' => null, 'scheme' => null];
			$referer_host = $referer['host'];
			if (!empty($referer['port'])) {
				$referer_host = $referer['host'].':'.$referer['port'];
			}
		}
		$cors_white_hosts = self::getParam('cors_white_hosts');

		if ($referer && is_array($cors_white_hosts)) {
			foreach ($cors_white_hosts as $host) {
				if (substr($referer['host'], -strlen($host)) == $host) {
					$headers->set('Access-Control-Allow-Origin', $referer['scheme'].'://'.$referer_host);
					break;
				}
			}
		}

		if (YII_ENV != 'prod') {
			$headers->set('Access-Control-Allow-Origin', '*');
			if (!empty($referer_host)) {
				$headers->set('Access-Control-Allow-Origin', $referer['scheme'].'://'.$referer_host);
			}
		}
	}

	/**
	 * MD5签名
	 * @return string
	 * @author luotaipeng
	 */
	public function sign($data, $secret, $ignore_keys = ['sign'])
	{
		foreach ($ignore_keys as $key) {
			if (isset($data[$key])) {
				unset($data[$key]);
			}
		}
		ksort($data);
		foreach ($data as $k => $v) {
			$data[$k] = urlencode($v);
		}
		$sign = md5(implode('&', $data).$secret);
		return $sign;
	}

	/**
	 * 生成微信订单号
	 * @param  null   $mch_id
	 * @param  null   $prefix
	 * @param  null   $suffix
	 * @return string
	 * @author luotaipeng
	 */
	public function gen_order_no($mch_id = null, $prefix = null, $suffix = null)
	{
		if (!$mch_id) {
			require_once Yii::getAlias('@common/WxPay/lib/WxPay.Api.php');
			$mch_id = \WxPayConfig::MCHID;
		}

		return $prefix.$mch_id.date('YmdHis').rand(100, 999).$suffix;
	}

	/**
	 * 检查是否为微信客户端
	 * @return bool
	 * @author luotaipeng
	 */
	public static function is_wx_client()
	{
		// Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1 wechatdevtools/0.7.0 MicroMessenger/6.3.9 Language/zh_CN webview/0
		if (isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger/')) {
			return true;
		}
		return false;
	}

	/**
	 * 获取随机名称
	 * @author luotaipeng
	 */
	public static function getRandName($last_name = [], $suffix = '团友')
	{
		if (!$last_name) {
			$last_name = '
				赵 钱 孙 李 周 吴 郑 王 冯 陈 褚 卫
				蒋 沈 韩 杨 朱 秦 尤 许 何 吕 施 张
				孔 曹 严 华 金 魏 陶 姜 戚 谢 邹 喻
				柏 水 窦 章 云 苏 潘 葛 奚 范 彭 郎
				鲁 韦 昌 马 苗 凤 花 方 俞 任 袁 柳
				酆 鲍 史 唐 费 廉 岑 薛 雷 贺 倪 汤
				滕 殷 罗 毕 郝 邬 安 常 乐 于 时 傅
				皮 卞 齐 康 伍 余 元 卜 顾 孟 平 黄
				和 穆 萧 尹 姚 邵 湛 汪 祁 毛 禹 狄
				米 贝 明 臧 计 伏 成 戴 谈 宋 茅 庞';
			$last_name = trim($last_name);
			$last_name = str_replace(["\n", "\t"], [' ', null], $last_name);
			$last_name = explode(' ', $last_name);
		}
		return $last_name[array_rand($last_name)].$suffix;
	}

	/**
	 * 获取随机时间
	 * @author luotaipeng
	 */
	public static function getRandTime($last_minute = null, $start_date = null, $end_date = null, $start_hour = 8, $end_hour = 22)
	{
		$hour = rand($start_hour, $end_hour);
		if (!$start_date) {
			$start_date = strtotime(date('Y-m-d').' -3day');
		}
		if (!$end_date) {
			$end_date = strtotime('last day of this month');
		}
		$minute = rand(0, 59);
		if ($last_minute) {
			$last_minute = rand(1, $last_minute);
			$start_date = $end_date = strtotime('today');
			$hour = date('H');
			$minute = date('i') - $last_minute;
			if ($minute < 0) {
				$minute += 60;
				$hour--;
			}
		}
		$day = rand($start_date, $end_date);
		$day = date('Y-m-d ', $day);
		return $day.$hour.':'.$minute.':'.rand(0, 59);
	}

	/**
	 * 获取隐藏四位电话号码
	 * @author luotaipeng
	 */
	public static function getMaskMobile($mobile = null)
	{
		if ($mobile) {
			return substr($mobile, 0, 3).'****'.substr($mobile, -2);
		}
		$prefix_list = [132, 134, 135, 136, 137, 150, 159, 180, 189];
		return $prefix_list[array_rand($prefix_list)].'******'.rand(10, 99);
	}

	public static function maskMobile($mobile)
	{
		if (empty($mobile)) {
			return '';
		}
		if (Yii::$app->user->id == 1) {
			return $mobile;
		}
		return substr($mobile, 0, 3).'****'.substr($mobile, -4);
	}

	public static function randString($len = 8, $level = 1)
	{
		$strs = [
			'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
			'abcdefghijk0123456789lmnopqrstuvwxyz68920ABCDEFGHIJKLMN0123456789OPQRSTUVWXYZ',
			'abcdefghijk0123456789lmnopqr@#$%?&*_+-stuvwxyz68920ABCDEFGHIJK@#$%?&*_+-LMN0123456789OPQRSTUVWXYZ',
		];
		$str = ArrayHelper::getValue($strs, $level, $strs[1]);
		$l = strlen($str) - 1;
		$rand_str = '';
		for ($i = 0; $i < $len; $i++) {
			$rand_str .= $str[mt_rand(0, $l)];
		}
		return $rand_str;
	}
}
