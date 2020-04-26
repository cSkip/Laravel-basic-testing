<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginControllerTest extends TestCase
{

    /**
     * RefreshDatabase
     * Trait that refreshes the DB before the tests are executed
     * It will run migrations
     */
    use RefreshDatabase;

    /**
     * @covers \App\Http\Controllers\Auth\LoginController::login
     */
    public function testLogin()
    {
        // Test that you can get to the login page and it returns a 200 status
        $response = $this->get(route('login'));
        $response->assertStatus(200);
    }

    /**
     * @covers \App\Http\Controllers\Auth\LoginController::login
     */
    public function testLoginDisplaysView()
    {
        // Test that you can get to the login page and get the correct view returned to the page
        $response = $this->get(route('login'));
        $response->assertViewIs('auth.login');
    }

    /**
     * @covers \App\Http\Controllers\Auth\LoginController::login
     */
    public function testLoginShowsErrors()
    {
        // Send empty post
        $response = $this->post('/login', []);

        // Assert status and Error
        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');
    }

    /**
     * @covers \App\Http\Controllers\Auth\LoginController::login
     */
    public function testLoginAuthenticatesAndRedirectsUser()
    {

        // Use Factory to create user
        $user = factory(User::class)->create();

        // Post user to login page
        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        // User was logged in, redirected to the home page and authenticated
        $response->assertRedirect(route('home'));
        $this->assertAuthenticatedAs($user);
    }

}
