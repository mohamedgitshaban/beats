<?php

return [
    'navigation' => [
        'group' => 'المستخدمون',
    ],

    'fields' => [
        'name' => 'الاسم',
        'phone' => 'رقم الهاتف',
        'password' => 'كلمة المرور',
        'status' => 'الحالة',
        'verified' => 'موثق',
        'created_at' => 'تاريخ الإنشاء',
    ],

    'status' => [
        'active' => 'نشط',
        'inactive' => 'غير نشط',
        'pending_otp' => 'بانتظار رمز OTP',
        'pending_verification' => 'بانتظار التحقق',
    ],

    'admin' => [
        'navigation_label' => 'المشرفون',
        'model_label' => 'مشرف',
        'plural_model_label' => 'المشرفون',
    ],

    'client' => [
        'navigation_label' => 'العملاء',
        'model_label' => 'عميل',
        'plural_model_label' => 'العملاء',
    ],
];
