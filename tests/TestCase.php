<?php

use App\User;
use Tests\CreatesApplication;
use Tests\TestsHelper;

abstract class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    use CreatesApplication, TestsHelper;

}
