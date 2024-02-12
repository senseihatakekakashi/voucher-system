<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupUser;
use App\Models\User;
use App\Services\CUDService;
use App\Services\DecryptService;
use Illuminate\Http\Request;
use Redirect;

class UserController extends Controller
{
    protected $cudService;
    protected $decryptService;

    public function __construct()
    {
        $this->cudService = new CUDService;
        $this->decryptService = new DecryptService;
    }

    public function index(Request $request)
    {
        $id = $this->decryptService->decrypt($request->key);
        $group = Group::with('users')->find($id);
        $unallocated_users = User::whereDoesntHave('groups')->role('users')->orderBy('name')->get();
        
        return view('pages.users.index')
                ->with('group', $group)
                ->with('unallocated_users', $unallocated_users);
    } 

    public function update(Request $request, string $id)
    {
        $data = [
            'group_id' => $this->decryptService->decrypt($request->group),
            'user_id' => $this->decryptService->decrypt($id),
        ];
        GroupUser::create($data);
        return Redirect::back();
    }

    public function destroy(string $id)
    {
        $group_user = GroupUser::where('user_id', $this->decryptService->decrypt($id));
        $this->cudService->delete($group_user);
        return Redirect::back();
    }
}
