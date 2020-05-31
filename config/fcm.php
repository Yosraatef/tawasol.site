<?php

return [
    'driver' => env('FCM_PROTOCOL', 'http'),
    'log_enabled' => false,

    'http' => [
        'server_key' => 'AAAAIndOseI:APA91bHoKfenVV-G0Pq7x0vxGHKaOIKeCbK4WTN1J2KSY9BvNns2-dcvPUQ2Ndc1ftnTQ-wMnLya7ct0z_LW83L8ByLVrXQaMrJCzaqP4R9fLekqVKCgqtIewjFprP6UcRUHndY93qDS',
        'sender_id' => '148030534114',
        'server_send_url' => 'https://fcm.googleapis.com/fcm/send',
        'server_group_url' => 'https://android.googleapis.com/gcm/notification',
        'timeout' => 30.0, // in second
    ],
];