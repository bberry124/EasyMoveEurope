<?php

return [
    'ContactCaptcha'   => [
        'length'    => 5,
        'width'     => 120,
        'height'    => 36,
        'quality'   => 90,
        'math'      => true, //Enable Math Captcha
        'expire'    => 60,   //Stateless/API captcha expiration
    ],
    // ...
];