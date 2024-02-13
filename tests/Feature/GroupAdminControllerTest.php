<?php

namespace Tests\Feature;

use App\Models\Group;
use App\Models\GroupUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Crypt;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class GroupAdminControllerTest extends TestCase
{
    use RefreshDatabase; // Rollback database transactions after each test

    public function setUp(): void
    {
        parent::setUp();

        // Create roles for testing
        Role::create(['name' => 'super-admin']);
        Role::create(['name' => 'group-admin']);
        Role::create(['name' => 'users']);
    }

    /** 
     * Super admin can access GroupAdminController index method.
     * @test 
     */
    public function test_super_admin_can_access_group_admin_controller()
    {
        $user = User::factory()->create()->assignRole('super-admin');
        $this->actingAs($user);

        $response = $this->get('/group-admins'); // Update the URL as per your route
        $response->assertOk();
    }

    /** 
     * Group admin cannot access GroupAdminController index method.
     * @test 
     */
    public function test_group_admin_cannot_access_group_admin_controller()
    {
        $user = User::factory()->create()->assignRole('group-admin');
        $this->actingAs($user);

        $this->expectException(\Spatie\Permission\Exceptions\UnauthorizedException::class);

        $response = $this->get('/group-admins'); // Update the URL as per your route
        $response->assertResponseStatus(403);
    }

    /** 
     * Users cannot access GroupAdminController index method.
     * @test 
     */
    public function test_users_cannot_access_group_admin_controller()
    {
        $user = User::factory()->create()->assignRole('users');
        $this->actingAs($user);

        $this->expectException(\Spatie\Permission\Exceptions\UnauthorizedException::class);

        $response = $this->get('/group-admins'); // Update the URL as per your route
        $response->assertResponseStatus(403);
    }

    /** 
     * Super admin can access GroupAdminController show method.
     * @test 
     */
    public function test_super_admin_can_access_group_admin_show_method()
    {
        $user = User::factory()->create()->assignRole('super-admin');
        $this->actingAs($user);

        $groupAdmin = User::factory()->create()->assignRole('group-admin');
        $group_id = Crypt::encryptString($groupAdmin->id);
        $response = $this->get("/group-admins/{$group_id}"); // Update the URL as per your route
        $response->assertOk();
    }

    /** 
     * Group admin cannot access GroupAdminController show method.
     * @test 
     */
    public function test_group_admin_cannot_access_group_admin_show_method()
    {
        $user = User::factory()->create()->assignRole('group-admin');
        $this->actingAs($user);

        $groupAdmin = User::factory()->create()->assignRole('group-admin');

        $this->expectException(\Spatie\Permission\Exceptions\UnauthorizedException::class);

        $group_id = Crypt::encryptString($groupAdmin->id);
        $response = $this->get("/group-admins/{$group_id}"); // Update the URL as per your route
        $response->assertResponseStatus(403);
    }

    /** 
     * Users cannot access GroupAdminController show method.
     * @test 
     */
    public function test_users_cannot_access_group_admin_show_method()
    {
        $user = User::factory()->create()->assignRole('users');
        $this->actingAs($user);

        $groupAdmin = User::factory()->create()->assignRole('group-admin');

        $this->expectException(\Spatie\Permission\Exceptions\UnauthorizedException::class);

        $group_id = Crypt::encryptString($groupAdmin->id);
        $response = $this->get("/group-admins/{$group_id}"); // Update the URL as per your route
        $response->assertResponseStatus(403);
    }

    /** 
     * Super admin can update group admin.
     * @test 
     */
    public function test_super_admin_can_update_group_admin()
    {
        $this->withoutExceptionHandling(); // Remove this line in production

        $user = User::factory()->create()->assignRole('super-admin');
        $this->actingAs($user);

        $groupAdmin = User::factory()->create()->assignRole('group-admin');

        // Assuming $groupAdmin->id is the user ID of the group admin
        $group_admin_id = Crypt::encryptString($groupAdmin->id);

        $groups = Group::factory(3)->create(); // Create 3 groups for testing

        $encryptedGroupIds = $groups->pluck('id')->map(function ($groupId) {
            return Crypt::encryptString($groupId);
        })->toArray();

        $response = $this->put("/group-admins/{$group_admin_id}", [
            'groups' => $encryptedGroupIds,
            // Add other fields as needed
        ]);

        $response->assertRedirect();

        // Assert database changes if any
        $this->assertDatabaseHas('group_user', [
            'user_id' => $groupAdmin->id,
            'group_id' => $groups->pluck('id')->toArray(),
        ]);
    }

    /** 
     * Group admin cannot update group admin.
     * @test 
     */
    public function test_group_admin_cannot_update_group_admin()
    {
        $groupAdmin = User::factory()->create()->assignRole('group-admin');
        $this->actingAs($groupAdmin);

        $groupAdminToBeUpdated = User::factory()->create()->assignRole('group-admin');
        $group_admin_id = Crypt::encryptString($groupAdminToBeUpdated->id);

        $groups = Group::factory(3)->create();

        $encryptedGroupIds = $groups->pluck('id')->map(function ($groupId) {
            return Crypt::encryptString($groupId);
        })->toArray();

        $this->expectException(\Spatie\Permission\Exceptions\UnauthorizedException::class);

        $response = $this->put("/group-admins/{$group_admin_id}", [
            'groups' => $encryptedGroupIds,
            // Add other fields as needed
        ]);

        $response->assertForbidden();

        // Assert that the database remains unchanged
        // Add specific assertions if needed
    }

    /** 
     * Users cannot update group admin.
     * @test 
     */
    public function test_users_cannot_update_group_admin()
    {
        $user = User::factory()->create()->assignRole('users');
        $this->actingAs($user);

        $groupAdminToBeUpdated = User::factory()->create()->assignRole('group-admin');
        $group_admin_id = Crypt::encryptString($groupAdminToBeUpdated->id);

        $groups = Group::factory(3)->create();

        $encryptedGroupIds = $groups->pluck('id')->map(function ($groupId) {
            return Crypt::encryptString($groupId);
        })->toArray();

        $this->expectException(\Spatie\Permission\Exceptions\UnauthorizedException::class);

        $response = $this->put("/group-admins/{$group_admin_id}", [
            'groups' => $encryptedGroupIds,
            // Add other fields as needed
        ]);

        $response->assertForbidden();

        // Assert that the database remains unchanged
        // Add specific assertions if needed
    }

    /** 
     * Super admin can delete group admin from group.
     * @test 
     */
    public function test_super_admin_can_delete_group_admin_from_group()
    {
        $this->withoutExceptionHandling(); // Remove this line in production

        $superAdmin = User::factory()->create()->assignRole('super-admin');
        $this->actingAs($superAdmin);

        $groupAdminToDelete = User::factory()->create()->assignRole('group-admin');
        $groupToDelete = Group::factory()->create();

        $groupUser = GroupUser::create([
            'user_id' => $groupAdminToDelete->id,
            'group_id' => $groupToDelete->id,
        ]);

        $group_admin_id = Crypt::encryptString($groupAdminToDelete->id);
        $group_id = Crypt::encryptString($groupToDelete->id);

        $response = $this->delete("/group-admins/{$group_id}", [
            'user' => $group_admin_id,
            // Add other fields as needed
        ]);

        $response->assertRedirect();

        // Assert that the database has no record of the deleted relationship
        $this->assertDatabaseMissing('group_user', [
            'user_id' => $groupAdminToDelete->id,
            'group_id' => $groupToDelete->id,
        ]);
    }

    /** 
     * Group admin cannot delete group admin from group.
     * @test 
     */
    public function test_group_admin_cannot_delete_group_admin_from_group()
    {
        $groupAdmin = User::factory()->create()->assignRole('group-admin');
        $this->actingAs($groupAdmin);

        $groupAdminToDelete = User::factory()->create()->assignRole('group-admin');
        $groupToDelete = Group::factory()->create();

        $groupUser = GroupUser::create([
            'user_id' => $groupAdminToDelete->id,
            'group_id' => $groupToDelete->id,
        ]);

        $group_admin_id = Crypt::encryptString($groupAdminToDelete->id);
        $group_id = Crypt::encryptString($groupToDelete->id);
        
        $this->expectException(\Spatie\Permission\Exceptions\UnauthorizedException::class);
        
        $response = $this->delete("/group-admins/{$group_id}", [
            'user' => $group_admin_id,
            // Add other fields as needed
        ]);

        $response->assertForbidden();

        // Assert that the database remains unchanged
        $this->assertDatabaseHas('group_user', [
            'user_id' => $groupAdminToDelete->id,
            'group_id' => $groupToDelete->id,
        ]);
    }

    /** 
     * Users cannot delete group admin from group.
     * @test 
     */
    public function test_users_cannot_delete_group_admin_from_group()
    {
        $user = User::factory()->create()->assignRole('users');
        $this->actingAs($user);

        $groupAdminToDelete = User::factory()->create()->assignRole('group-admin');
        $groupToDelete = Group::factory()->create();

        $groupUser = GroupUser::create([
            'user_id' => $groupAdminToDelete->id,
            'group_id' => $groupToDelete->id,
        ]);

        $group_admin_id = Crypt::encryptString($groupAdminToDelete->id);
        $group_id = Crypt::encryptString($groupToDelete->id);

        $this->expectException(\Spatie\Permission\Exceptions\UnauthorizedException::class);
        
        $response = $this->delete("/group-admins/{$group_id}", [
            'user' => $group_admin_id,
            // Add other fields as needed
        ]);

        $response->assertForbidden();

        // Assert that the database remains unchanged
        $this->assertDatabaseHas('group_user', [
            'user_id' => $groupAdminToDelete->id,
            'group_id' => $groupToDelete->id,
        ]);
    }
}