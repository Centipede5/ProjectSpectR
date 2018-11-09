<?php

namespace Tests\Feature;
use App\Http\Controllers\UserProfileController;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoggedInUserTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUserLogginIn()
    {
        $user = new User;
    }
}
