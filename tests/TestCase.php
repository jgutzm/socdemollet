<?php

use App\User;

abstract class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */

    /**
     * @var \App\User
     */
    protected $defaultUser;

    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    public function defaultUser(array $attributes = [])
    {
        if ($this->defaultUser) {
          return $this->defaultUser;
        }
        return $this->defaultUser = factory(User::class)->create($attributes);
    }

    protected function createPost(array $attributes = [])
    {
        return factory(\App\Post::class)->create($attributes);
    }

    protected function anyone()
    {
        return factory(\App\User::class)->create();
    }
}
