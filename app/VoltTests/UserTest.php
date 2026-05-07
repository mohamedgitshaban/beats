<?php

namespace App\VoltTests;

use VoltTest\Laravel\Contracts\VoltTestCase;
use VoltTest\Laravel\VoltTestManager;

class UserTest implements VoltTestCase
{
    /**
     * Define the test scenario.
     *
     * @param VoltTestManager $manager
     * @return void
     */
    public function define(VoltTestManager $manager): void
    {
        // Define your test scenario
        $scenario = $manager->scenario('UserTest');

        // Step 1 : Sanctum.csrfCookie
        $scenario->step('Sanctum.csrfCookie')
            ->get('/sanctum/csrf-cookie', ['Content-Type' => 'application/x-www-form-urlencoded'])
            ->expectStatus(200);

        // Step 2 : Ignition.healthCheck
        $scenario->step('Ignition.healthCheck')
            ->get('/_ignition/health-check', ['Content-Type' => 'application/x-www-form-urlencoded'])
            ->expectStatus(200);

        // Step 3 : Ignition.executeSolution
        $scenario->step('Ignition.executeSolution')
            ->post('/_ignition/execute-solution', [
            '_token' => '${csrf_token}',
                // Add form fields here
            ], ['Content-Type' => 'application/x-www-form-urlencoded'])
            ->expectStatus(200);

        // Step 4 : Ignition.updateConfig
        $scenario->step('Ignition.updateConfig')
            ->post('/_ignition/update-config', [
            '_token' => '${csrf_token}',
                // Add form fields here
            ], ['Content-Type' => 'application/x-www-form-urlencoded'])
            ->expectStatus(200);

        // Step 5 : ApiUser
        $scenario->step('ApiUser')
            ->get('/api/user', ['Authorization' => 'Bearer ${token}', 'Content-Type' => 'application/json', 'Accept' => 'application/json'])
            ->expectStatus(200);

        // Step 6 : 
        $scenario->step('')
            ->get('/', ['Content-Type' => 'application/x-www-form-urlencoded'])
            ->expectStatus(200);
    }
}