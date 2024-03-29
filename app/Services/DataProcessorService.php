<?php

namespace App\Services;

use App\Models\Group;
use App\Models\User;
use App\Models\VoucherCode;
use App\Services\DecryptService;
use Carbon\Carbon;
use Illuminate\Support\Str;

/**
 * Class DataProcessorService
 *
 * This class provides various data processing operations, including group administration,
 * user access filtering, voucher code generation, and pagination.
 *
 * @package App\Services
 */
class DataProcessorService
{
    /**
     * @var DecryptService $decryptService
     */
    protected $decryptService;

    /**
     * DataProcessorService constructor.
     */
    public function __construct()
    {
        $this->decryptService = new DecryptService;
    }

    /**
     * Assign group admins to groups with appropriate timestamps and decrypted IDs.
     *
     * @param int $group_admin_id The encrypted ID of the group admin.
     * @param array $groups An array of encrypted group IDs.
     *
     * @return array
     */
    public function assignGroupAdminsToGroup($group_admin_id, $groups)
    {
        $data = [];

        if (count($groups) > 0) {
            foreach ($groups as $key => $group) {
                $data[$key] = [
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                    'group_id' => $this->decryptService->decrypt($group),
                    'user_id' => $this->decryptService->decrypt($group_admin_id),
                ];
            }
        }

        return $data;
    }

    /**
     * Filter group admin's access to groups based on user roles.
     *
     * @param \App\Models\User $user The user object.
     *
     * @return \App\Models\Group[]|\Illuminate\Database\Eloquent\Collection|null
     */
    public function filterGroupAdminsAccessToGroups($user)
    {
        if ($user->hasRole('super-admin'))
            $groups = Group::orderBy('name')->get(['id', 'name']);
        elseif ($user->hasRole('group-admin'))
            $groups = User::with('groups')->orderBy('name')->find($user->id)->groups;
        else
            $groups = null;

        return $groups;
    }

    /**
     * Generate a unique voucher code.
     *
     * @return string
     */
    public function generateUniqueVoucherCode()
    {
        do {
            $code = strtoupper(Str::random(6));
        } while (VoucherCode::where('voucher_code', $code)->exists());

        return $code;
    }

    /**
     * Generate voucher codes for the specified quantity.
     *
     * @param int $voucher_quantity The quantity of voucher codes to generate.
     *
     * @return array An array of voucher code data with user_id and unique voucher_code.
     */
    public function processVoucherCode($voucher_quantity)
    {
        // Initialize an empty array to store voucher code data
        $data = [];

        // Loop through the specified quantity to generate unique voucher codes
        for($i=0; $i < $voucher_quantity; $i++) {
            $data[$i] = [
                'user_id' => auth()->user()->id,
                'voucher_code' => $this->generateUniqueVoucherCode(),
            ];
        }

        // Return the generated voucher code data
        return $data;
    }
    
    /**
     * Check if the user has reached the maximum number of voucher codes allowed.
     *
     * @param int $user_id The ID of the user.
     * @param int $quantity The quantity of voucher codes to be added.
     *
     * @return bool Returns true if the user has reached the maximum limit, false otherwise.
     */
    public function maxVoucherNumberReached($user_id, $quantity): bool
    {
        // Calculate the total count of existing voucher codes for the user
        $currentVoucherCount = VoucherCode::where('user_id', $user_id)->count();

        // Check if adding the specified quantity exceeds the configured limit
        return ($currentVoucherCount + $quantity) > config('vouchercode.limit');
    }

    /**
     * Paginate user vouchers based on the given page.
     *
     * @param int $page The page number.
     *
     * @return \Illuminate\Support\Collection
     */
    public function paginateVouchers($voucher_per_page)
    {
        return VoucherCode::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->paginate($voucher_per_page);
    }
}