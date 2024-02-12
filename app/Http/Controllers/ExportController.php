<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use App\Services\DecryptService;
use App\Services\ExportCSVService;
use Illuminate\Http\Request;

class ExportController extends Controller
{   
    protected $decryptService;
    protected $exportCSVService;

    public function __construct()
    {
        $this->decryptService = new DecryptService;
        $this->exportCSVService = new ExportCSVService;
    }

    public function index()
    {
        $users = User::with('voucherCodes')->orderBy('name')->get();
        $csvFile = $this->exportCSVService->exportAll($users);
        return response()->download($csvFile)->deleteFileAfterSend(true);
    }

    public function show(string $id)
    {
        $group = Group::find($this->decryptService->decrypt($id));   
        $csvFile = $this->exportCSVService->exportGroupUsers($group);
        return response()->download($csvFile)->deleteFileAfterSend(true);
    }
}
