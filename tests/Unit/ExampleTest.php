<?php

namespace Tests\Unit;

use Tests\TestCase; // Use Laravel's TestCase instead of PHPUnit's TestCase
use App\Models\User; // Import the User model
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    use RefreshDatabase; // Ensure the database is refreshed for each test

    /**
     * A basic test example.
     */
    public function test_that_true_is_true(): void
    {
        $this->assertTrue(true);
    }

    /**
     * Test if a user can be created and exists in the database.
     */
    public function testUserCanBeCreated()
    {
        $user = User::factory()->create(); // Create a user using the factory
        $this->assertDatabaseHas('users', ['email' => $user->email]); // Assert the user exists
    }

    public function testHomePageIsAccessible()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function testApiReturnsData()
    {
        $response = $this->getJson('/api/users');
        $response->assertJsonStructure(['data']);
    }
}
