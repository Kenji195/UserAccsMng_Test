<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\UserRegistry;

class UserSessionsTests extends TestCase
{
    //use RefreshDatabase;

    protected $token;

    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
    }

    public function test_can_register_new_user(): void
    {
        $response = $this->postJson('/api/register', [
            'username' => 'testUser',
            'email' => 'testUser@gmail.com',
            'password' => 'testUser'
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'access_token'
        ]);

        $this->assertDatabaseHas('user_registries', [
            'email' => 'testUser@gmail.com'
        ]);

        $token = $response->json('access_token');
    }

    public function test_can_logout_user(): void
    {
        $this->test_can_login_user();

        $response = $this->postJson('/api/logout', [], [
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Successfully logged out'
        ]);
    }

    public function test_can_login_user(): void
    {
        $response = $this->postJson('/api/login', [
            'email' => 'testUser@gmail.com',
            'password' => 'testUser'
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'access_token'
        ]);

        $this->token = $response->json('access_token');
    }

    public function test_can_get_all_users(): void
    {
        $this->test_can_login_user();

        $response = $this->postJson('/api/allUsers', [], [
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'userRegistries' => [
                '*' => ['id', 'username', 'email']
            ]
        ]);
    }

    public function test_can_get_single_user(): void
    {
        $this->test_can_login_user();

        $user = UserRegistry::first();
        
        $response = $this->postJson('/api/getUser/' . $user->id, [], [
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id', 'username', 'email'
        ]);
    }

    public function test_can_add_new_user(): void
    {
        $this->test_can_login_user();

        $response = $this->postJson('/api/insertUser', [
            'username' => 'anotherUser',
            'email' => 'anotherUser@gmail.com',
            'password' => 'anotherUser'
        ], [
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'New user was registered!',
            'code' => 200
        ]);

        $this->assertDatabaseHas('user_registries', [
            'email' => 'anotherUser@gmail.com'
        ]);
    }

    public function test_can_edit_new_user(): void
    {
        $this->test_can_login_user();

        $user = UserRegistry::latest('id')->first();
        
        $response = $this->postJson('/api/editUser/' . $user->id, [
            'username' => 'anotherUserEdited',
            'email' => 'anotherUser@gmail.com'
        ], [
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'User registry was updated!',
            'code' => 200
        ]);

        $this->assertDatabaseHas('user_registries', [
            'username' => 'anotherUserEdited'
        ]);
    }

    public function test_can_delete_added_user(): void
    {
        $this->test_can_login_user();

        $user = UserRegistry::where('email', 'anotherUser@gmail.com')->first();
        
        $response = $this->postJson('/api/deleteUser/' . $user->id, [], [
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'User registry deleted',
            'code' => 200
        ]);

        $this->assertDatabaseMissing('user_registries', [
            'email' => 'anotherUser@gmail.com'
        ]);
    }

    public function test_can_self_delete(): void
    {
        $this->test_can_login_user();

        $user = UserRegistry::where('email', 'testUser@gmail.com')->first();
        
        $response = $this->postJson('/api/deleteUser/' . $user->id, [], [
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'User registry deleted',
            'code' => 200
        ]);

        $this->assertDatabaseMissing('user_registries', [
            'email' => 'testUser@gmail.com'
        ]);
    }
}
