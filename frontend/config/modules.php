<?php

$config = [
    'master' => [
        'class' => 'frontend\modules\master\Module',
        'layout' => '@frontend/views/layouts/master',
    ],
    'api' => [
        'class' => 'frontend\modules\api\Module',
        'layout' => '@frontend/views/layouts/api',
    ],
];

return $config;
