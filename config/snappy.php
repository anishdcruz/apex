<?php

return array(


    'pdf' => [
        'enabled' => true,
        'binary'  => '/usr/local/bin/wkhtmltopdf',
        'timeout' => false,
        'options' => [
            'header-html' => base_path('storage/app/header.html'),
            'footer-html' => base_path('storage/app/footer.html'),
            'margin-left' => 4,
            'margin-right' => 4,
            'margin-bottom' => 22,
            'margin-top' => 42
        ],
        'env'     => [],
    ],
    'image' => [
        'enabled' => true,
        'binary'  => '/usr/local/bin/wkhtmltoimage',
        'timeout' => false,
        'options' => [],
        'env'     => [],
    ],


);
