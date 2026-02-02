<?php
namespace Tests\Feature;

use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class AddressSecurityTest extends TestCase
{
    use RefreshDatabase; // Resets the database after each test

    #[Test]
    public function a_user_can_update_their_own_address()
    {
        $user = User::factory()->create();
        $address = UserAddress::create([
            'user_id' => $user->id,
            'city' => 'Old City',
            'name' => 'Home',
            'full_address' => '123 Main St'
        ]);

        $response = $this->actingAs($user)
                        ->putJson("/api/auth/addresses/{$address->id}", [
                            'city' => 'New Secure City',
                            'name' => 'Home',
                            'full_address' => '123 Main St'
                        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('user_addresses', [
            'id' => $address->id,
            'city' => 'New Secure City'
        ]);
    }

    #[Test]
    public function a_user_cannot_update_another_users_address()
    {
        $owner = User::factory()->create();
        $hacker = User::factory()->create();
        $address = UserAddress::create([
            'user_id' => $owner->id,
            'city' => 'Original City',
            'name' => 'Home',
            'full_address' => '123 Main St'
        ]);

        $response = $this->actingAs($hacker)
                        ->putJson("/api/auth/addresses/{$address->id}", [
                            'city' => 'Hacked City',
                            'name' => 'Home',
                            'full_address' => '123 Main St'
                        ]);

        // Assert Forbidden
        $response->assertStatus(403);
        
        // Double check the database was NOT changed
        $this->assertDatabaseHas('user_addresses', [
            'id' => $address->id,
            'city' => 'Original City'
        ]);
    }
    
    #[Test]
    public function a_user_can_delete_their_own_address()
    {
        // 1. Create a user and an address belonging to them
        $user = User::factory()->create();
        $address = UserAddress::create([
            'user_id' => $user->id,
            'city' => 'Original City',
            'name' => 'Home',
            'full_address' => '123 Main St'
            ]);

        // 2. Act as that user and attempt to delete
        $response = $this->actingAs($user)
                         ->deleteJson("/api/auth/addresses/{$address->id}");

        // 3. Assert success
        $response->assertStatus(200);
        $this->assertDatabaseMissing('user_addresses', ['id' => $address->id]);
    }

    #[Test]
    public function a_user_cannot_delete_another_users_address()
    {
        // 1. Create two different users
        $owner = User::factory()->create();
        $hacker = User::factory()->create();
        
        // 2. Create an address for the owner
        $address = UserAddress::create([
            'user_id' => $owner->id,
            'city' => 'Original City',
            'name' => 'Home',
            'full_address' => '123 Main St'
        ]);

        // 3. Act as the hacker and try to delete the owner's address
        $response = $this->actingAs($hacker)
                         ->deleteJson("/api/auth/addresses/{$address->id}");

        // 4. Assert that access is forbidden
        $response->assertStatus(403);
        $this->assertDatabaseHas('user_addresses', ['id' => $address->id]);
    }
}