<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupUser;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\DecryptService;
use App\Services\DataProcessorService;
use App\Services\CUDService;
use Redirect;

class GroupAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $group_admins = User::role('group-admin')->get();
        return view('pages.group-admins.index')->with('group_admins', $group_admins);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user_id = (new DecryptService)->decrypt($id);
        $group_admin = User::role('group-admin')->find($user_id); 
        $group_admin_groups = User::with('groups')->find($user_id);
        // dd($group_admin_groups);
        $groups = Group::orderBy('name')->get(['id', 'name']);
        return view('pages.group-admins.assign-group-admins')
                ->with('group_admin', $group_admin)
                ->with('group_admin_groups', $group_admin_groups)
                ->with('groups', $groups);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $group_user = GroupUser::where('user_id', (new DecryptService)->decrypt($id));
        (new CUDService)->delete($group_user);

        $data = (new DataProcessorService)->assignGroupAdminsToGroup($id, $request->groups);
        GroupUser::insert($data);
        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $user_id = (new DecryptService)->decrypt($request->user);
        $group_id = (new DecryptService)->decrypt($id);
        GroupUser::where('user_id', $user_id)->where('group_id', $group_id)->delete();
        return Redirect::back();
    }
}
