<?php

namespace Tests\Feature;

use App\Models\Group;
use App\Models\GroupUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Crypt;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        // Create roles for testing
        Role::create(['name' => 'super-admin']);
        Role::create(['name' => 'group-admin']);
        Role::create(['name' => 'users']);
    }

    /** @test */
    public function super_admin_can_access_user_controller()
    {
        $user = User::factory()->create()->assignRole('super-admin');
        $this->actingAs($user);

        $group = Group::factory()->create();
        
        $response = $this->get("/users?key=" . Crypt::encryptString($group->id));
        $response->assertOk();
    }

    /** @test */
    public function group_admin_can_access_user_controller()
    {
        $user = User::factory()->create()->assignRole('group-admin');
        $this->actingAs($user);

        $group = Group::factory()->create();
        
        $response = $this->get("/users?key=" . Crypt::encryptString($group->id));
        $response->assertOk();
    }

    /** @test */
    public function users_cannot_access_user_controller()
    {
        $user = User::factory()->create()->assignRole('users');
        $this->actingAs($user);

        $group = Group::factory()->create();

        $this->expectException(\Spatie\Permission\Exceptions\UnauthorizedException::class);

        $response = $this->get("/users?key=" . Crypt::encryptString($group->id));
        $response->assertResponseStatus(403);
    }

    /** @test */
    public function super_admin_can_update_user_group_association()
    {
        $this->withoutExceptionHandling();

        $superAdmin = User::factory()->create()->assignRole('super-admin');
        $this->actingAs($superAdmin);

        $group = Group::factory()->create();
        $userToUpdate = User::factory()->create();

        $id = Crypt::encryptString($userToUpdate->id);
        $response = $this->put("/users/{$id}", [
            'group' => Crypt::encryptString($group->id),
            // Add other fields as needed
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('group_user', [
            'user_id' => $userToUpdate->id,
            'group_id' => $group->id,
        ]);
    }

    /** @test */
    public function group_admin_can_update_user_group_association()
    {
        $this->withoutExceptionHandling();

        $groupAdmin = User::factory()->create()->assignRole('group-admin');
        $this->actingAs($groupAdmin);

        $group = Group::factory()->create();
        $userToUpdate = User::factory()->create();

        $id = Crypt::encryptString($userToUpdate->id);
        $response = $this->put("/users/{$id}", [
            'group' => Crypt::encryptString($group->id),
            // Add other fields as needed
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('group_user', [
            'user_id' => $userToUpdate->id,
            'group_id' => $group->id,
        ]);
    }

    /** @test */
    public function users_cannot_update_user_group_association()
    {
        $user = User::factory()->create()->assignRole('users');
        $this->actingAs($user);

        $userToUpdate = User::factory()->create();

        $this->expectException(\Spatie\Permission\Exceptions\UnauthorizedException::class);

        $id = Crypt::encryptString($userToUpdate->id);
        $response = $this->put("/users/{$id}", [
            'group' => Crypt::encryptString(Group::factory()->create()->id),
            // Add other fields as needed
        ]);

        $response->assertForbidden();
    }

    /** @test */
    public function super_admin_can_remove_user_group_association()
    {
        $superAdmin = User::factory()->create()->assignRole('super-admin');
        $this->actingAs($superAdmin);

        $user = User::factory()->create();
        $group = Group::factory()->create();
        GroupUser::create(['user_id' => $user->id, 'group_id' => $group->id]);

        $user_id = Crypt::encryptString($user->id);
        $group_id = Crypt::encryptString($group->id);
        $response = $this->delete("/users/{$user_id}", ['group' => $group_id]);

        $response->assertRedirect();

        $this->assertDatabaseMissing('group_user', [
            'user_id' => $user->id,
            'group_id' => $group->id,
        ]);
    }

    /** @test */
    public function group_admin_can_remove_user_group_association()
    {
        $groupAdmin = User::factory()->create()->assignRole('group-admin');
        $this->actingAs($groupAdmin);

        $user = User::factory()->create();
        $group = Group::factory()->create();
        GroupUser::create(['user_id' => $user->id, 'group_id' => $group->id]);

        $user_id = Crypt::encryptString($user->id);
        $group_id = Crypt::encryptString($group->id);
        $response = $this->delete("/users/{$user_id}", ['group' => $group_id]);

        $response->assertRedirect();

        $this->assertDatabaseMissing('group_user', [
            'user_id' => $user->id,
            'group_id' => $group->id,
        ]);
    }

    /** @test */
    public function users_cannot_remove_user_group_association()
    {
        $user = User::factory()->create()->assignRole('users');
        $this->actingAs($user);

        $userToDelete = User::factory()->create();
        $group = Group::factory()->create();
        GroupUser::create(['user_id' => $userToDelete->id, 'group_id' => $group->id]);

        $this->expectException(\Spatie\Permission\Exceptions\UnauthorizedException::class);

        $user_id = Crypt::encryptString($userToDelete->id);
        $group_id = Crypt::encryptString($group->id);
        $response = $this->delete("/users/{$user_id}", ['group' => $group_id]);

        $response->assertForbidden();

        $this->assertDatabaseHas('group_user', [
            'user_id' => $userToDelete->id,
            'group_id' => $group->id,
        ]);
    }
}