<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Models\Group;
use App\Services\CUDService;
use App\Services\DataProcessorService;
use App\Services\DecryptService;
use Redirect;


class GroupController extends Controller
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
        $groups = $this->dataProcessorService->filterGroupAdminsAccessToGroups(auth()->user());
        return view('pages.groups.index')->with('groups', $groups);
    }

    public function store(StoreGroupRequest $request)
    {
        $this->cudService->create($request, (new Group));
        return Redirect::back();
    }

    public function edit($id)
    {
        $group = Group::find($this->decryptService->decrypt($id));    
        return view('pages.groups.edit')->with('group', $group);
    }

    public function update(UpdateGroupRequest $request, Group $group)
    {
        $this->cudService->update($request, $group);
        return Redirect::back();
    }

    public function destroy($id)
    {
        $group = Group::find($this->decryptService->decrypt($id));
        $this->cudService->delete($group);
        return Redirect::back();
    }
}
