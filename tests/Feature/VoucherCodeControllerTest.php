<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\VoucherCode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Crypt;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class VoucherCodeControllerTest extends TestCase
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

    /** 
     * Super admin should not access the VoucherCodeController.
     * @test 
     */
    public function super_admin_cannot_access_voucher_code_controller()
    {
        $superAdmin = User::factory()->create()->assignRole('super-admin');
        $this->actingAs($superAdmin);
        
        // Expect an unauthorized exception when trying to access
        $this->expectException(\Spatie\Permission\Exceptions\UnauthorizedException::class);
        
        $response = $this->get("/voucher-codes");
        $response->assertForbidden();
    }

    /** 
     * Group admin should not access the VoucherCodeController.
     * @test 
     */
    public function group_admin_cannot_access_voucher_code_controller()
    {
        $groupAdmin = User::factory()->create()->assignRole('group-admin');
        $this->actingAs($groupAdmin);

        // Expect an unauthorized exception when trying to access
        $this->expectException(\Spatie\Permission\Exceptions\UnauthorizedException::class);

        $response = $this->get("/voucher-codes");
        $response->assertForbidden();
    }

    /** 
     * Users should be able to access the VoucherCodeController.
     * @test 
     */
    public function users_can_access_voucher_code_controller()
    {
        $user = User::factory()->create()->assignRole('users');
        $this->actingAs($user);

        $response = $this->get("/voucher-codes");
        $response->assertOk();
    }

    /** 
     * Super admin should not be able to store a voucher code.
     * @test 
     */
    public function super_admin_cannot_store_voucher_code()
    {
        $superAdmin = User::factory()->create()->assignRole('super-admin');
        $this->actingAs($superAdmin);

        // Expect an unauthorized exception when trying to store
        $this->expectException(\Spatie\Permission\Exceptions\UnauthorizedException::class);

        $response = $this->post("/voucher-codes");
        $response->assertForbidden();
    }

    /** 
     * Group admin should not be able to store a voucher code.
     * @test 
     */
    public function group_admin_cannot_store_voucher_code()
    {
        $groupAdmin = User::factory()->create()->assignRole('group-admin');
        $this->actingAs($groupAdmin);

        // Expect an unauthorized exception when trying to store
        $this->expectException(\Spatie\Permission\Exceptions\UnauthorizedException::class);

        $response = $this->post("/voucher-codes");
        $response->assertForbidden();
    }

    /** 
     * Users should be able to store a voucher code.
     * @test 
     */
    public function users_can_store_voucher_code()
    {
        $user = User::factory()->create()->assignRole('users');
        $this->actingAs($user);

        $response = $this->post("/voucher-codes");
        $response->assertRedirect();

        // Add assertions for database changes if needed
    }

    /** 
     * Super admin should not be able to destroy a voucher code.
     * @test 
     */
    public function super_admin_cannot_destroy_voucher_code()
    {
        $superAdmin = User::factory()->create()->assignRole('super-admin');
        $this->actingAs($superAdmin);

        // Expect an unauthorized exception when trying to destroy
        $this->expectException(\Spatie\Permission\Exceptions\UnauthorizedException::class);
        
        $id = Crypt::encryptString(1);
        $response = $this->delete("/voucher-codes/{$id}");
        $response->assertForbidden();
    }

    /** 
     * Group admin should not be able to destroy a voucher code.
     * @test 
     */
    public function group_admin_cannot_destroy_voucher_code()
    {
        $groupAdmin = User::factory()->create()->assignRole('group-admin');
        $this->actingAs($groupAdmin);

        // Expect an unauthorized exception when trying to destroy
        $this->expectException(\Spatie\Permission\Exceptions\UnauthorizedException::class);
        
        $id = Crypt::encryptString(1);
        $response = $this->delete("/voucher-codes/{$id}");
        $response->assertForbidden();
    }

    /** 
     * Users should be able to destroy a voucher code.
     * @test 
     */
    public function users_can_destroy_voucher_code()
    {
        $user = User::factory()->create()->assignRole('users');
        $this->actingAs($user);

        // Create a voucher code
        $voucherCode = VoucherCode::factory()->create();
        $id = Crypt::encryptString($voucherCode->id);

        $response = $this->delete("/voucher-codes/{$id}");
        $response->assertRedirect();

        // Add assertions for database changes if needed
    }
}