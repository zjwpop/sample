<?php

namespace common\helpers;

use common\models\table\WxReply;
use common\models\Wechat;
use yii\base\BaseObject;
use yii\base\InvalidValueException;

class WeChatMsg extends BaseObject
{
	/** @var array */
	public $data;

	/** @var array */
	private $_msg;

	/**
	 * 获取要发送的消息
	 * @return string|false
	 */
	public function getMsg()
	{
		if (empty($this->data)) {
			throw new InvalidValueException('微信数据不能为空');
		}

		$msg = $this->_generateMsg();
		return $msg;
	}

	/**
	 * 生成消息
	 * @return string
	 */
	private function _generateMsg()
	{
		$data = $this->data;

		$msg_type = null;
		$msg_content = null;
		switch ($data['MsgType']) {
			case WxReply::MSG_TYPE_EVENT:
				if ($data['Event'] == Wechat::EVENT_MENU_CLICK) {
					$msg_type = WxReply::MSG_TYPE_BUTTON_KEY;
					$msg_content = $data['EventKey'];
				} else {
					$msg_type = WxReply::MSG_TYPE_EVENT_KEY;
					$msg_content = $data['Event'];
				}
				break;
			case WxReply::MSG_TYPE_TEXT:
				$msg_type = WxReply::MSG_TYPE_TEXT_KEY;
				$msg_content = $data['Content'];
				$msg_content = preg_replace_callback('/[\xf0-\xf7].{3}/', function ($matches) {
					return '';
				}, $msg_content);
				$msg_content = trim($msg_content);
				break;
		}

		if ($msg_type !== null && !empty($msg_content)) {
			$wxReply = WxReply::find()->where([
				'msg_content' => $msg_content,
				'msg_type' => $msg_type,
				'status' => WxReply::STATUS_ENABLE,
			])->cache(1)->one();
			if (!empty($wxReply)) {
				switch ($wxReply->reply_type) {
					case WxReply::REPLY_TYPE_TEXT_KEY:
						$this->_text($wxReply->reply_content);
						break;
				}
			} else {
				// 没有对该消息进行设定时回复默认内容
				if ($data['MsgType'] == WxReply::MSG_TYPE_EVENT) {
					return '';
				}
				$this->_defaultReply();
			}
		} else {
			if ($data['MsgType'] == WxReply::MSG_TYPE_EVENT) {
				return '';
			}
			// 没有对该类型消息进行设定时回复默认内容
			$this->_defaultReply();
		}

		$this->_msg['ToUserName'] = $data['FromUserName'];
		$this->_msg['FromUserName'] = $data['ToUserName'];
		$this->_msg['CreateTime'] = time();
		return Wechat::arrayToXml($this->_msg);
	}

	/**
	 * 默认回复消息
	 */
	private function _defaultReply()
	{
		$msg = "低价买车<a href='https://c.namaiche.com/car/style-price.html'>点这里</a>";
		$this->_text($msg);
	}

	/**
	 * 回复文本消息
	 * @param string $msg
	 */
	private function _text($msg)
	{
		$this->_msg['MsgType'] = WxReply::REPLY_TYPE_TEXT;
		$this->_msg['Content'] = $msg;
	}
}
