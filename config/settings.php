<?php

return [
    'vat' => [
        'pl' => 0.23,
    ],
    'payment' => [
        'fee' => '15', // percent (%) if not set in DB ()
        'ratelimit' => '50',
        'bonus_fee' => '7',
        'order_deadline_hours' => '7',
        'min_withdrawal_balance' => '150',
    ],
    'project_time_to_complete_max' => '1440', // 1440 = 24 hours
    'project_time_to_complete' => [// more then letters
        '7000' => '420', // 420 = 7 hours
        '15000' => '720', // 720 = 12 hours
        '999999999999' => '1440', // 1440 = 24 hours
    ],
    'rules_file' => [
        'path' => public_path('/rules.pdf'),
        'email_name' => 'Rules-of-use-service.pdf',
    ],
    'project_not_reserved' => '420', // 420 = 7 hours
];
