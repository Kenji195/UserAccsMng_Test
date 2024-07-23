<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\UserRegistry;

class DefaultRegistries extends TestCase
{

    protected $token;

    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
    }

    public function test_can_register_new_user1(): void
    {
        $response = $this->postJson('/api/register', [
            'username' => 'NewUser1',
            'email' => 'new1@gmail.com',
            'password' => 'new1'
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'access_token'
        ]);

        $this->assertDatabaseHas('user_registries', [
            'email' => 'new1@gmail.com'
        ]);

        $token = $response->json('access_token');
    }

    public function test_can_login_user1(): void
    {
        $response = $this->postJson('/api/login', [
            'email' => 'new1@gmail.com',
            'password' => 'new1'
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'access_token'
        ]);

        $this->token = $response->json('access_token');
    }

    public function test_can_logout_user1(): void
    {
        $this->test_can_login_user1();

        $response = $this->postJson('/api/logout', [], [
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Successfully logged out'
        ]);
    }

    public function test_can_register_new_user2(): void
    {
        $response = $this->postJson('/api/register', [
            'username' => 'NewUser2',
            'email' => 'new2@gmail.com',
            'password' => 'new2'
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'access_token'
        ]);

        $this->assertDatabaseHas('user_registries', [
            'email' => 'new2@gmail.com'
        ]);

        $token = $response->json('access_token');
    }

    public function test_can_login_user2(): void
    {
        $response = $this->postJson('/api/login', [
            'email' => 'new2@gmail.com',
            'password' => 'new2'
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'access_token'
        ]);

        $this->token = $response->json('access_token');
    }

    public function test_can_logout_user2(): void
    {
        $this->test_can_login_user2();

        $response = $this->postJson('/api/logout', [], [
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Successfully logged out'
        ]);
    }
}
