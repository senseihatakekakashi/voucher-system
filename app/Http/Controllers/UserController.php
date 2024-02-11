<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupUser;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\DecryptService;
use App\Services\CUDService;
use Redirect;
use Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $id = (new DecryptService)->decrypt($request->key);
        $group = Group::with('users')->find($id);
        $unallocated_users = User::whereDoesntHave('groups')->role('users')->get();
        Session::put('group_id', $id);
        
        return view('pages.users.index')
                ->with('group', $group)
                ->with('unallocated_users', $unallocated_users);
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
        // 
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
        $data = [
            'group_id' => (new DecryptService)->decrypt($request->group),
            'user_id' => (new DecryptService)->decrypt($id),
        ];
        GroupUser::create($data);
        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $group_user = GroupUser::where('user_id', (new DecryptService)->decrypt($id));
        (new CUDService)->delete($group_user);
        return Redirect::back();
    }
}
