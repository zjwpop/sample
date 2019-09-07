<?php

namespace backend\common\extensions;

use yii\captcha\CaptchaValidator as YiiCaptchaValidator;

class CaptchaValidator extends YiiCaptchaValidator
{
    public $captchaAction = '/site/captcha';
}
