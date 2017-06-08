<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    Use DatabaseTransactions;
    
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $name = 'Jesus Gutierrez';
        $email = 'admin@styde.net';
        $user = factory(\App\User::class)->create([
          'name' => $name,
          'email' => $email,
        ]);

        $this->actingAs($user, 'api')
             ->visit('api/user')
             ->see($name)
             ->see($email);
    }
}
