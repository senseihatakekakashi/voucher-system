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

/**
 * Class GroupAdminController
 *
 * Controller for managing group admins and their associated actions.
 *
 * @package App\Http\Controllers
 */
class GroupAdminController extends Controller
{
    /**
     * @var CUDService $CUDService
     */
    protected $CUDService;

    /**
     * @var DataProcessorService $dataProcessorService
     */
    protected $dataProcessorService;

    /**
     * @var DecryptService $decryptService
     */
    protected $decryptService;

    /**
     * GroupAdminController constructor.
     */
    public function __construct()
    {
        $this->CUDService = new CUDService;
        $this->dataProcessorService = new DataProcessorService;
        $this->decryptService = new DecryptService;
    }

    /**
     * Display a listing of group admins.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $group_admins = User::role('group-admin')->get();
        return view('pages.group-admins.index')->with('group_admins', $group_admins);
    }

    /**
     * Show the specified group admin and their assigned groups.
     *
     * @param string $id
     * @return \Illuminate\View\View
     */
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

    /**
     * Update the assigned groups for a group admin.
     *
     * @param Request $request
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, string $id)
    {
        $group_user = GroupUser::where('user_id', $this->decryptService->decrypt($id));
        $this->CUDService->delete($group_user);

        $data = $this->dataProcessorService->assignGroupAdminsToGroup($id, $request->groups);
        GroupUser::insert($data);
        return Redirect::back();
    }

    /**
     * Remove the specified group from a group admin's assigned groups.
     *
     * @param Request $request
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, string $id)
    {
        $user_id = $this->decryptService->decrypt($request->user);
        $group_id = $this->decryptService->decrypt($id);
        GroupUser::where('user_id', $user_id)->where('group_id', $group_id)->delete();
        return Redirect::back();
    }
}