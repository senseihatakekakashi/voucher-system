<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupUser;
use App\Models\User;
use App\Services\CUDService;
use App\Services\DecryptService;
use Illuminate\Http\Request;
use Redirect;

/**
 * Class UserController
 *
 * Controller for managing users and their group associations.
 *
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    /**
     * @var CUDService $CUDService
     */
    protected $CUDService;

    /**
     * @var DecryptService $decryptService
     */
    protected $decryptService;

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->CUDService = new CUDService;
        $this->decryptService = new DecryptService;
    }

    /**
     * Display a listing of users in a specific group and unallocated users.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Decrypt the received key using DecryptService
        $group_id = $this->decryptService->decrypt($request->key);

        // Enforce access control check using policy
        if (! $this->authorize('view', app(Group::class)->find($group_id))) {
            abort(403);
        }

        // Retrieve the group with associated users
        $group = Group::with('users')->find($group_id);

        // Fetch unallocated users with the "users" role
        $unallocated_users = User::whereDoesntHave('groups')
            ->role('users')
            ->orderBy('name')
            ->get();

        // Render the view with necessary data
        return view('pages.users.index')
            ->with('group', $group)
            ->with('unallocated_users', $unallocated_users);
    }

    /**
     * Update the specified user's group association.
     *
     * @param Request $request
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, string $id)
    {
        $data = [
            'group_id' => $this->decryptService->decrypt($request->group),
            'user_id' => $this->decryptService->decrypt($id),
        ];
        GroupUser::create($data);
        return Redirect::back();
    }

    /**
     * Remove the specified user's group association.
     *
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $id)
    {
        $group_user = GroupUser::where('user_id', $this->decryptService->decrypt($id));
        $group_id = $group_user->first()->group_id;

        // Enforce access control check using policy
        if (! $this->authorize('view', app(Group::class)->find($group_id))) {
            abort(403);
        }

        $this->CUDService->delete($group_user);
        return Redirect::back();
    }
}