<?php

class ExampleTest extends FeatureTestCase
{
    function test_basic_example()
    {
        $username = 'Jesus Gutierrez';
        $email = 'admin@styde.net';
        $user = factory(\App\User::class)->create([
          'username' => $username,
          'email' => $email,
        ]);

        $this->actingAs($user, 'api')
             ->visit('api/user')
             ->see($username)
             ->see($email);
    }
}
