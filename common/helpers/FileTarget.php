<?php

namespace common\helpers;

use Yii;
use common\helpers\Helper;
use yii\helpers\ArrayHelper;
use yii\log\FileTarget as YiiFileTarget;

/**
 * 文件日志类(重写)
 * @author luotaipeng
 */
class FileTarget extends YiiFileTarget
{

	/**
	 * 写入日志文件
	 * @author luotaipeng
	 */
	public function export()
	{
		$http_exception_list = [
			'\yii\web\BadRequestHttpException',
			'\yii\web\ConflictHttpException',
			'\yii\web\ForbiddenHttpException',
			'\yii\web\GoneHttpException',
			'\yii\web\MethodNotAllowedHttpException',
			'\yii\web\NotAcceptableHttpException',
			'\yii\web\NotFoundHttpException',
			'\yii\web\RangeNotSatisfiableHttpException',
			'\yii\web\ServerErrorHttpException',
			'\yii\web\TooManyRequestsHttpException',
			'\yii\web\UnauthorizedHttpException',
			'\yii\web\UnprocessableEntityHttpException',
			'\yii\web\UnsupportedMediaTypeHttpException',
		];
		foreach ($http_exception_list as $http_exception) {
			if ($this->messages[0][0] instanceof $http_exception) {
				$this->logFile = str_replace('/app.log', '/app.'.$this->messages[0][0]->statusCode.'.log', $this->logFile);
			}
		}

		$ignore_http_error = [400, 401, 404, 405];
		$status_code = isset($this->messages[0][0]->statusCode) ? $this->messages[0][0]->statusCode : 0;
		if (Helper::getParam('send_error_report') && empty($GLOBALS['sent_error_report']) && !in_array($status_code, $ignore_http_error)) {
			$GLOBALS['sent_error_report'] = 1;
			$app_id = Yii::$app->id;

			$receiver = null;
			$assign_map = [
				// 罗太鹏
				'luotaipeng@namaiche.com' => [],
				// 胡倍玮
				'hubeiwei@namaiche.com' => ['m', 'pc'],
				// 祝俊巍
				'zhujunwei@namaiche.com' => ['admin', 'console'],
			];
			foreach ($assign_map as $key => $map) {
				if (in_array($app_id, $map)) {
					$receiver = $key;
					break;
				}
			}
			if (!$receiver) {
				$receiver = reset(array_keys($assign_map));
			}
			unset($assign_map[$receiver]);
			$cc = array_keys($assign_map);

			$sender = ArrayHelper::getValue(Yii::$app->components, 'mailer.transport.username');
			$text = implode("\n", array_map([$this, 'formatMessage'], $this->messages)) . "\n";

			Yii::$app->mailer->compose()
				->setFrom($sender)
				->setTo($receiver)
				->setCc($cc)
				->setSubject('['.strtoupper($app_id).' - 线上错误报告] '.$this->messages[0][0]->getMessage())
				->setHtmlBody('<pre>'.$text.'</pre><hr>'.date('Y-m-d H:i:s'))
				->send();

		}

		parent::export();
	}

}
