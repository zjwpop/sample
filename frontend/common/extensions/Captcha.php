<?php

namespace backend\common\extensions;

use yii\captcha\Captcha as YiiCaptcha;

class Captcha extends YiiCaptcha
{
    public $captchaAction = '/site/captcha';

    public $imageOptions = [
        'alt' => '验证码',
    ];

    public $template = '<div class="row"><div class="col-xs-4">{input}</div><div class="col-xs-8">{image}</div></div>';

    public $options = [
        'class' => 'form-control input-sm',
        'maxlength' => 4,
    ];
}
