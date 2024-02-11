<?php

namespace App\Services;
use App\Models\Group;
use App\Models\User;
use App\Services\DecryptService;
use Carbon\Carbon;

class DataProcessorService
{
    public function assign_group_admins_to_group($group_admin_id, $groups) {
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

    public function filter_group_admins_access_to_groups($user) {
        if($user->hasRole('super-admin'))
            $groups = Group::orderBy('name')->get(['id', 'name']);
        elseif($user->hasRole('group-admin'))
            $groups = User::with('groups')->orderBy('name')->find($user->id)->groups;
        else
            $groups = null;

        return $groups;
    }
}