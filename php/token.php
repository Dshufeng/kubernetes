<?php
$config = [
        "connection"=>[
            "type"=>"vnc",
            "settings"=>[
                "hostname"=>"10.244.1.126", // the vnc server ip
                "port"=>5901,				// the vnc server port
                "password"=>"123456"   // the vnc server psssword
            ]
        ]
    ];

    $iv= substr(md5("cepo"),8,16);
    $value = \openssl_encrypt(
        json_encode($config),
        'AES-256-CBC',
        'MySuperSecretKeyForParamsToken12',
        0,
        $iv
    );

    if ($value === false) {
        throw new \Exception('Could not encrypt the data.');
    }

    $data = [
        'iv' => base64_encode($iv),
        'value' => $value,
    ];

    $json = json_encode($data);

    if (!is_string($json)) {
        throw new \Exception('Could not encrypt the data.');
    }

    // you token
    echo base64_encode($json);
