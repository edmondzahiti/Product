<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testRegister()
    {
        $data = [
            'name' => 'test name',
            'email' => 'test@example.com',
            'password' => 'password123',
        ];

        $response = $this->post('/api/register', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    }

    public function testLoginWithValidCredentials()
    {
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $data = [
            'email' => 'test@example.com',
            'password' => 'password123',
        ];

        $response = $this->post('/api/login', $data);

        $response->assertStatus(200);
        $this->assertArrayHasKey('token', $response->json());
    }

    public function testLoginWithInvalidCredentials()
    {
        $data = [
            'email' => 'nonexistent@example.com',
            'password' => 'invalidpassword',
        ];

        $response = $this->post('/api/login', $data);

        $response->assertStatus(401);
        $response->assertJson(['error' => 'Invalid credentials']);
    }
}
