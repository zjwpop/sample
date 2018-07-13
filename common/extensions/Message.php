<?php

namespace common\extensions;

use yii;

class Message {

    /*发送营销短信*/
    public function sendMsg($to,$templateId,$param = null)
    {
        $options['accountsid'] = Yii::$app->params['accountSid'];
        $options['token'] = Yii::$app->params['token'];
        $ucpass = new Ucpaas($options);
        $appId = Yii::$app->params['msgAppId'];

        return $ucpass->templateSMS($appId,$to,$templateId,$param);
    }

    /*发送短信验证码**/
    public  function sendValidateMsg($to,$code)
    {
        $options['accountsid'] = Yii::$app->params['accountSid'];
        $options['token'] = Yii::$app->params['token'];

        $ucpass = new Ucpaas($options);
        $appId = Yii::$app->params['msgAppId'];
        $templateId =  Yii::$app->params['validateTempId'];
        $param = $code;

        return $ucpass->templateSMS($appId,$to,$templateId,$param);
    }

    /*绑定虚拟号码*/
    public function chooseNumber($callee,$dstVirtualNum,$cardno,$name,$cityId,$requestId)
    {
        $options['accountsid'] = Yii::$app->params['accountSid'];
        $options['token'] = Yii::$app->params['token'];
        $ucpass = new Ucpaas($options);
        $appId = Yii::$app->params['msgAppId'];

        return $ucpass->chooseNumber($appId, $callee, $dstVirtualNum, $cardno, $name, $cityId, $requestId, $type = 'json');
    }

    /*解绑虚拟号*/
    public  function unbindNumber($bindId,$cityId)
    {
        $options['accountsid'] = Yii::$app->params['accountSid'];
        $options['token'] = Yii::$app->params['token'];
        $ucpass = new Ucpaas($options);
        $appId = Yii::$app->params['msgAppId'];

        return $ucpass->unbindNumber($appId, $bindId,$cityId, $type = 'json');
    }

    /*顾问拨打客户电话---绑定业务电话*/
    public  function setCallerNumber($bindId,$caller,$cityId,$requestId)
    {
        $options['accountsid'] = Yii::$app->params['accountSid'];
        $options['token'] = Yii::$app->params['token'];
        $ucpass = new Ucpaas($options);
        $appId = Yii::$app->params['msgAppId'];

        return $ucpass->setCallerNumber($appId, $bindId,$caller,$cityId,$requestId,$type = 'json');
    }

    /*彩印发送*/
    /*密码：namaiche2017*/
    public  function sendColorSms($mobile,$templateId,$param)
    {
        $options['accountsid'] = Yii::$app->params['accountSid'];
        $options['token'] = Yii::$app->params['token'];
        $ucpass = new Ucpaas($options);
        $clientId = Yii::$app->params['clientId'];

        return $ucpass->sendColorSMS($clientId,'nm123456',$mobile,$templateId,$param,$type = 'json');
    }
}
