<?php

namespace App\Policies;

use App\Models\User;
use App\Models\VoucherCode;
use Illuminate\Auth\Access\HandlesAuthorization;

class VoucherCodePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user The user attempting to delete the voucher code.
     * @param VoucherCode $voucherCode The voucher code being considered.
     * @return bool True if the user can delete the voucher code, false otherwise.
     */
    public function delete(User $user, VoucherCode $voucherCode): bool
    {
        // to ensure users can only delete their own voucher codes
        return $user->id === $voucherCode->user_id;
    }
}