<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupUser;
use App\Models\User;
use App\Services\CUDService;
use App\Services\DataProcessorService;
use App\Services\DecryptService;
use Illuminate\Http\Request;
use Redirect;

class GroupAdminController extends Controller
{
    protected $cudService;
    protected $dataProcessorService;
    protected $decryptService;

    public function __construct()
    {
        $this->cudService = new CUDService;
        $this->dataProcessorService = new DataProcessorService;
        $this->decryptService = new DecryptService;
    }

    public function index()
    {
        $group_admins = User::role('group-admin')->get();
        return view('pages.group-admins.index')->with('group_admins', $group_admins);
    }

    public function show(string $id)
    {
        $user_id = $this->decryptService->decrypt($id);
        $group_admin = User::role('group-admin')->find($user_id); 
        $group_admin_groups = User::with('groups')->find($user_id);
        $groups = Group::orderBy('name')->get(['id', 'name']);
        
        return view('pages.group-admins.assign-group-admins')
                ->with('group_admin', $group_admin)
                ->with('group_admin_groups', $group_admin_groups)
                ->with('groups', $groups);
    }

    public function update(Request $request, string $id)
    {
        $group_user = GroupUser::where('user_id', $this->decryptService->decrypt($id));
        $this->cudService->delete($group_user);

        $data = $this->dataProcessorService->assignGroupAdminsToGroup($id, $request->groups);
        GroupUser::insert($data);
        return Redirect::back();
    }

    public function destroy(Request $request, string $id)
    {
        $user_id = $this->decryptService->decrypt($request->user);
        $group_id = $this->decryptService->decrypt($id);
        GroupUser::where('user_id', $user_id)->where('group_id', $group_id)->delete();
        return Redirect::back();
    }
}
