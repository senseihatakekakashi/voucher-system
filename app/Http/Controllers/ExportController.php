<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\ExportCSVService;
use App\Services\DecryptService;
use League\Csv\Writer;


class ExportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('voucherCodes')->orderBy('name')->get();
        $csvFile = (new ExportCSVService)->exportAll($users);
        return response()->download($csvFile)->deleteFileAfterSend(true);
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
        $group = Group::find((new DecryptService)->decrypt($id));   
        $csvFile = (new ExportCSVService)->exportGroupUsers($group);
        return response()->download($csvFile)->deleteFileAfterSend(true);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
