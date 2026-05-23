<?php

return [
    'navigation' => [
        'group' => 'Users',
    ],

    'fields' => [
        'name' => 'Name',
        'phone' => 'Phone',
        'password' => 'Password',
        'status' => 'Status',
        'verified' => 'Verified',
        'created_at' => 'Created At',
    ],

    'status' => [
        'active' => 'Active',
        'inactive' => 'Inactive',
        'pending_otp' => 'Pending OTP',
        'pending_verification' => 'Pending Verification',
    ],

    'admin' => [
        'navigation_label' => 'Admins',
        'model_label' => 'Admin',
        'plural_model_label' => 'Admins',
    ],

    'client' => [
        'navigation_label' => 'Clients',
        'model_label' => 'Client',
        'plural_model_label' => 'Clients',
    ],
];
