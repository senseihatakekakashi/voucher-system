<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use App\Services\DecryptService;
use App\Services\ExportCSVService;
use Illuminate\Http\Request;

/**
 * Class ExportController
 *
 * Controller for handling CSV exports of user and group data.
 *
 * @package App\Http\Controllers
 */
class ExportController extends Controller
{
    /**
     * @var DecryptService $decryptService
     */
    protected $decryptService;

    /**
     * @var ExportCSVService $exportCSVService
     */
    protected $exportCSVService;

    /**
     * ExportController constructor.
     */
    public function __construct()
    {
        $this->decryptService = new DecryptService;
        $this->exportCSVService = new ExportCSVService;
    }

    /**
     * Export all users and their voucher codes to a CSV file.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function index()
    {
        $users = User::with('voucherCodes')->orderBy('name')->get();
        $csvFile = $this->exportCSVService->exportAll($users);
        return response()->download($csvFile)->deleteFileAfterSend(true);
    }

    /**
     * Export users within a specific group and their voucher codes to a CSV file.
     *
     * @param string $id
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function show(string $id)
    {
        $group = Group::find($this->decryptService->decrypt($id));
        $csvFile = $this->exportCSVService->exportGroupUsers($group);
        return response()->download($csvFile)->deleteFileAfterSend(true);
    }
}