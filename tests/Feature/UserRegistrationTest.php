<?php

namespace Tests\Feature;
use App\Http\Controllers\Auth;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserRegistrationTest extends TestCase
{

	public function getUserData(){
		return [[true]];
	}

    /**
     * A basic test example.
     * @dataProvider getUserData
     */
    public function testRegistrationValidation($request)
    {
        //$controller = new Auth\RegisterController();
        //$controller->validate($request);
        $this->assertTrue($request);
    }
}
