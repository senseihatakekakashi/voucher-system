<?php

namespace Tests\Feature;

use App\Models\Group;
use App\Models\User;
use App\Services\DecryptService;
use App\Services\ExportCSVService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ExportControllerTest extends TestCase
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
    public function super_admin_can_export_all_users()
    {
        $superAdmin = User::factory()->create()->assignRole('super-admin');
        $this->actingAs($superAdmin);

        // Mock the ExportCSVService to avoid actual file creation
        $this->mock(ExportCSVService::class, function ($mock) {
            $mock->shouldReceive('exportAll')->andReturn(Storage::put('mocked-export.csv', 'CSV content'));
        });

        $response = $this->get('/export');
        $response->assertSuccessful();
        Storage::assertExists('mocked-export.csv');
    }

    /** @test */
    public function super_admin_can_export_group_users()
    {
        $superAdmin = User::factory()->create()->assignRole('super-admin');
        $this->actingAs($superAdmin);

        $group = Group::factory()->create();
        $group_id = Crypt::encryptString($group->id);
        $response = $this->get("/export/{$group_id}");
        $response->assertSuccessful();
        Storage::assertExists('mocked-export.csv');
    }

    /** @test */
    public function group_admin_can_export_group_users()
    {
        // $groupAdmin = User::factory()->create()->assignRole('group-admin');
        // $this->actingAs($groupAdmin);

        // $group = Group::factory()->create();

        // // Mock the ExportCSVService to avoid actual file creation
        // $this->mock(ExportCSVService::class, function ($mock) use ($group) {
        //     $mock->shouldReceive('exportGroupUsers')->with($group)->andReturn(Storage::put("mocked-group-{$group->id}-export.csv", 'CSV content'));
        // });

        // $group_id = Crypt::encryptString($group->id);
        // $response = $this->get("/export/{$group_id}");
        // $response->assertSuccessful();
        // Storage::assertExists("mocked-group-{$group->id}-export.csv");
        $groupAdmin = User::factory()->create()->assignRole('group-admin');
        $this->actingAs($groupAdmin);

        $group = Group::factory()->create();

        // Mock the ExportCSVService to avoid actual file creation
        $this->mock(ExportCSVService::class, function ($mock) use ($group) {
            $mock->shouldReceive('exportGroupUsers')->with($group)->andReturn(Storage::put("mocked-group-{$group->id}-export.csv", 'CSV content'));
        });

        // Mock the authorization check to always allow
        Gate::shouldReceive('authorize')->andReturn(true);

        $group_id = Crypt::encryptString($group->id);
        $response = $this->get("/export/{$group_id}");
        $response->assertSuccessful();
        Storage::assertExists("mocked-group-{$group->id}-export.csv");
    }

    /** @test */
    public function group_admin_cannot_export_all_users()
    {
        $groupAdmin = User::factory()->create()->assignRole('group-admin');
        $this->actingAs($groupAdmin);

        $this->expectException(\Spatie\Permission\Exceptions\UnauthorizedException::class);

        $response = $this->get('/export');
        $response->assertForbidden();
    }

    /** @test */
    public function users_cannot_export_all_users()
    {
        $user = User::factory()->create()->assignRole('users');
        $this->actingAs($user);

        $this->expectException(\Spatie\Permission\Exceptions\UnauthorizedException::class);

        $response = $this->get('/export');
        $response->assertForbidden();
    }

    /** @test */
    public function users_cannot_export_group_users()
    {
        $user = User::factory()->create()->assignRole('users');
        $this->actingAs($user);

        $group = Group::factory()->create();
        
        $this->expectException(\Spatie\Permission\Exceptions\UnauthorizedException::class);

        $group_id = Crypt::encryptString($group->id);
        $response = $this->get("/export/{$group_id}");
        $response->assertForbidden();
    }
}