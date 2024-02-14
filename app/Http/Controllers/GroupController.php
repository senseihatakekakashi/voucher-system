<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Models\Group;
use App\Services\CUDService;
use App\Services\DataProcessorService;
use App\Services\DecryptService;
use Redirect;

/**
 * Class GroupController
 *
 * Controller for managing groups and their associated actions.
 *
 * @package App\Http\Controllers
 */
class GroupController extends Controller
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
     * GroupController constructor.
     */
    public function __construct()
    {
        $this->CUDService = new CUDService;
        $this->dataProcessorService = new DataProcessorService;
        $this->decryptService = new DecryptService;
    }
    
    /**
     * Display a listing of groups based on the user's role.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $groups = $this->dataProcessorService->filterGroupAdminsAccessToGroups(auth()->user());
        return view('pages.groups.index')->with('groups', $groups);
    }

    /**
     * Store a newly created group.
     *
     * @param StoreGroupRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreGroupRequest $request)
    {
        $this->CUDService->create($request, (new Group));
        return Redirect::back();
    }

    /**
     * Show the form for editing the specified group.
     *
     * @param string $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $group = Group::find($this->decryptService->decrypt($id));    
        return view('pages.groups.edit')->with('group', $group);
    }

    /**
     * Update the specified group in storage.
     *
     * @param UpdateGroupRequest $request
     * @param Group $group
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateGroupRequest $request, Group $group)
    {
        $this->CUDService->update($request, $group);
        return redirect()->route('groups.index');
    }

    /**
     * Remove the specified group from storage.
     *
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $group = Group::find($this->decryptService->decrypt($id));
        $this->CUDService->delete($group);
        return Redirect::back();
    }
}