<?php

return [
    'forgot_password' => [
        'heading'            => 'Forgot your password?',
        'subheading'         => 'Enter your registered phone number and we will send you a verification code to reset your password.',
        'phone_label'        => 'Phone number',
        'phone_placeholder'  => 'Enter your phone number',
        'submit'             => 'Send',
        'back_to_login'      => 'Remembered your password?',
        'back_to_login_link' => 'Sign in',
        'not_found'          => 'No admin account found with this phone number.',
    ],

    'otp' => [
        'heading'          => 'Phone number verification',
        'subheading'       => 'We sent a 4-digit verification code to your phone:',
        'subheading_suffix'=> 'Please enter the code below to complete the process.',
        'resend'           => 'Resend code in:',
        'resend_now'       => 'Resend code',
        'verify'           => 'Verify',
        'invalid'          => 'The verification code is incorrect or has expired.',
        'no_session'       => 'Session expired. Please try again.',
    ],

    'reset_password' => [
        'heading'              => 'Reset your password',
        'subheading'           => 'Enter a new password to protect your account.',
        'new_password'         => 'New password',
        'password_placeholder' => 'Enter your password',
        'submit'               => 'Set password',
        'unauthorized'         => 'Unauthorized access. Please try again.',
    ],

    'success' => [
        'heading'    => 'Verified successfully',
        'subheading' => 'You can now sign in using your new password.',
        'login'      => 'Sign in',
    ],
];
