<?php

namespace App\Services;
use App\Models\Group;
use App\Models\User;
use App\Models\VoucherCode;
use App\Services\DecryptService;
use Carbon\Carbon;
use Illuminate\Support\Str;

class DataProcessorService
{
    public function assignGroupAdminsToGroup($group_admin_id, $groups) {
        if(count($groups) > 0) {
            foreach($groups as $key => $group) {
                $data[$key] = [
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                    'group_id' => (new DecryptService)->decrypt($group),
                    'user_id' => (new DecryptService)->decrypt($group_admin_id),
                ];
            }
        }

        return $data;
    }

    public function filterGroupAdminsAccessToGroups($user) {
        if($user->hasRole('super-admin'))
            $groups = Group::orderBy('name')->get(['id', 'name']);
        elseif($user->hasRole('group-admin'))
            $groups = User::with('groups')->orderBy('name')->find($user->id)->groups;
        else
            $groups = null;

        return $groups;
    }

    public function generateUniqueVoucherCode() {
        do {
            $code = strtoupper(Str::random(6));
        } while (VoucherCode::where('voucher_code', $code)->exists());
    
        return $code;
    }

    public function maxVoucherNumberReached($user_id) : bool {
        if(VoucherCode::where('user_id', $user_id)->count() > 9)
            return true;
        else
            return false;
    }

    public function paginateVouchers($page) {
        $perPage = 5;
        $voucher_codes = VoucherCode::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->get();
        return $voucher_codes->forPage($page, $perPage);
        
    }
}