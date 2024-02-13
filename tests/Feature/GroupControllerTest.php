<?php

namespace Tests\Feature;

use App\Models\Group;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Crypt;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class GroupControllerTest extends TestCase
{
    use RefreshDatabase; // Rollback database transactions after each test

    public function setUp(): void
    {
        parent::setUp();
        
        // Additional setup if needed

        // Create roles for testing
        Role::create(['name' => 'super-admin']);
        Role::create(['name' => 'group-admin']);
        Role::create(['name' => 'users']);
    }

    /** 
     * Super Admin Tests
     */

    /** @test */
    public function test_super_admin_can_create_a_group()
    {
        $user = User::factory()->create()->assignRole('super-admin');
        $this->actingAs($user);

        $response = $this->post('/groups', [
            'name' => 'New Group',
        ]);

        $this->assertDatabaseHas('groups', ['name' => 'New Group']);
    }

    /** @test */
    public function test_super_admin_can_read_groups()
    {
        $user = User::factory()->create()->assignRole('super-admin');
        $this->actingAs($user);

        Group::factory()->create(['name' => 'Test Group']);

        $response = $this->get('/groups');
        $response->assertOk();
        $response->assertSee('Test Group');
    }

    /** @test */
    public function test_super_admin_can_update_a_group()
    {
        $user = User::factory()->create()->assignRole('super-admin');
        $this->actingAs($user);

        $group = Group::factory()->create(['name' => 'Old Group']);

        $response = $this->put("/groups/{$group->id}", [
            'name' => 'Updated Group',
            // Add other fields as needed
        ]);

        $this->assertDatabaseHas('groups', ['name' => 'Updated Group']);
        $this->assertDatabaseMissing('groups', ['name' => 'Old Group']);
    }

    /** @test */
    public function test_super_admin_can_delete_a_group()
    {
        $user = User::factory()->create()->assignRole('super-admin');
        $this->actingAs($user);

        $group = Group::factory()->create();
        
        $group_id = Crypt::encryptString($group->id);
        $response = $this->delete("/groups/{$group_id}");
        $this->assertDatabaseMissing('groups', ['id' => $group->id]);
    }

    /** 
     * Group Admin Tests
     */

    /** @test */
    public function test_group_admin_cannot_create_a_group()
    {
        $user = User::factory()->create()->assignRole('group-admin');
        $this->actingAs($user);

        $this->expectException(\Spatie\Permission\Exceptions\UnauthorizedException::class);

        $response = $this->post('/groups', [
            'name' => 'New Group',
        ])->assertResponseStatus(403);
    }

    /** @test */
    public function test_group_admin_can_read_groups()
    {
        $user = User::factory()->create()->assignRole('group-admin');
        $this->actingAs($user);

        Group::factory()->create(['name' => 'Test Group']);

        $response = $this->get('/groups');
        $response->assertOk();
    }

    /** @test */
    public function test_group_admin_cannot_update_a_group()
    {
        $user = User::factory()->create()->assignRole('group-admin');
        $this->actingAs($user);

        $group = Group::factory()->create(['name' => 'Old Group']);

        $this->expectException(\Spatie\Permission\Exceptions\UnauthorizedException::class);

        $response = $this->put("/groups/{$group->id}", [
            'name' => 'Updated Group',
            // Add other fields as needed
        ]);

        $this->assertDatabaseHas('groups', ['name' => 'Old Group']);
        $response->assertResponseStatus(403);
    }

    /** @test */
    public function test_group_admin_cannot_delete_a_group()
    {
        $user = User::factory()->create()->assignRole('group-admin');
        $this->actingAs($user);

        $group = Group::factory()->create();

        $this->expectException(\Spatie\Permission\Exceptions\UnauthorizedException::class);

        $group_id = Crypt::encryptString($group->id);
        $response = $this->delete("/groups/{$group_id}");
        $this->assertDatabaseHas('groups', ['id' => $group->id]);
        $response->assertResponseStatus(403);
    }

    /** 
     * Users Tests
     */

    /** @test */
    public function test_users_cannot_create_a_group()
    {
        $user = User::factory()->create()->assignRole('users');
        $this->actingAs($user);

        $this->expectException(\Spatie\Permission\Exceptions\UnauthorizedException::class);

        $response = $this->post('/groups', [
            'name' => 'New Group',
        ]);
        $response->assertResponseStatus(403);
    }

    /** @test */
    public function test_users_cannot_read_groups()
    {
        $user = User::factory()->create()->assignRole('users');
        $this->actingAs($user);

        Group::factory()->create(['name' => 'Test Group']);

        $this->expectException(\Spatie\Permission\Exceptions\UnauthorizedException::class);
        $response = $this->get('/groups');
        $response->assertResponseStatus(403);
    }

    /** @test */
    public function test_users_cannot_update_a_group()
    {
        $user = User::factory()->create()->assignRole('users');
        $this->actingAs($user);

        $group = Group::factory()->create(['name' => 'Old Group']);

        $this->expectException(\Spatie\Permission\Exceptions\UnauthorizedException::class);

        $response = $this->put("/groups/{$group->id}", [
            'name' => 'Updated Group',
            // Add other fields as needed
        ]);

        $this->assertDatabaseHas('groups', ['name' => 'Old Group']);
        $response->assertResponseStatus(403);
    }

    /** @test */
    public function test_users_cannot_delete_a_group()
    {
        $user = User::factory()->create()->assignRole('users');
        $this->actingAs($user);

        $group = Group::factory()->create();

        $this->expectException(\Spatie\Permission\Exceptions\UnauthorizedException::class);

        $group_id = Crypt::encryptString($group->id);
        $response = $this->delete("/groups/{$group_id}");
        $this->assertDatabaseHas('groups', ['id' => $group->id]);
        $response->assertResponseStatus(403);
    }
}