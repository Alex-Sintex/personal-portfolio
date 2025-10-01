<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;

class UserTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function home_page_loads(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    #[Test]
    public function it_returns_users_list(): void
    {
        User::factory()->count(3)->create();
        $specialUser = User::factory()->create(['name' => 'John Doe']);

        $response = $this->get('/api/users');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => ['id', 'name', 'email', 'email_verified_at', 'created_at', 'updated_at'],
        ]);
        $response->assertJsonFragment(['name' => 'John Doe']);
        $response->assertJsonCount(4);
    }

    #[Test]
    public function it_returns_user_detail(): void
    {
        $user = User::factory()->create(['name' => 'John Doe']);

        $response = $this->get("/api/users/{$user->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure(['id', 'name', 'email', 'email_verified_at', 'created_at', 'updated_at']);
        $response->assertJsonFragment(['name' => 'John Doe']);
    }

    #[Test]
    public function it_returns_404_for_non_existing_user(): void
    {
        $response = $this->get('/api/users/999');

        $response->assertStatus(404);
    }
}
