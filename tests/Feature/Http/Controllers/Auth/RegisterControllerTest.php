<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterControllerTest extends TestCase
{
    /**
     * RefreshDatabase
     * Trait that refreshes the DB before the tests are executed
     * It will run migrations
     */
    use RefreshDatabase;

    /**
     * WithFaker
     * Trait used to fake data
     */
    use WithFaker;

    /**
     * @covers \App\Http\Controllers\Auth\RegisterController::register()
     */
    public function testRegisterNewUser()
    {

        // Post a user to the register controller
        $response = $this->post('register', [
            'name' => 'Joe Tester',
            'email' => 'jt@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        // Redirected after successful registration
        $response->assertRedirect(route('home'));

        // Check that the user was stored in the DB
        $this->assertDatabaseHas('users', [
            'name' => 'Joe Tester',
            'email' => 'jt@example.com',
        ]);
    }

    /**
     * @covers \App\Http\Controllers\Auth\RegisterController::create()
     * @covers \App\Http\Controllers\Auth\RegisterController::register()
     *
     */
    public function testRegisterAndCreateUser()
    {

        // Using faker to create parameter
        $name = $this->faker->name;
        $email = $this->faker->safeEmail;
        $password = $this->faker->password(8);

        // Post a user to the register controller
        $response = $this->post('register', [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password,
        ]);

        // Redirected after successful registration
        $response->assertRedirect(route('home'));

        // Find user in the DB
        $user = User::where('email', $email)->where('name', $name)->first();
        $this->assertNotNull($user);

        // Assert the user is authenticated
        $this->assertAuthenticatedAs($user);
    }

    /**
     * @covers \App\Http\Controllers\Auth\RegisterController::validate()
     */
    public function testRegisterReturnsValidationError()
    {
        // Post empty array
        $response = $this->post('register', []);

        // Assert 302 status
        $response->assertStatus(302);

        // Assert Errors
        $response->assertSessionHasErrors(['name', 'email', 'password']);
    }
}
