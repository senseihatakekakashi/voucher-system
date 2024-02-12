<?php

namespace App\Services;
use App\Models\Group;
use App\Models\User;
use App\Models\VoucherCode;
use League\Csv\Writer;

class ExportCSVService
{
    public function exportAll($model) {
        $csvData = [['No.', 'Name', 'Voucher Code']];
        $counter = 1;

        foreach ($model as $user) {
            $voucherCodes = $user->voucherCodes;

            foreach ($voucherCodes as $voucherCode) {
                $csvData[] = [$counter++, $user->name, $voucherCode->voucher_code];
            }
        }

        $csvFile = public_path('exports/all-users-and-voucher-codes.csv');
        $csv = Writer::createFromFileObject(new \SplFileObject($csvFile, 'w+'));
        $csv->insertAll($csvData);
    
        return $csvFile;
    }

    public function exportGroupUsers($group) {
        if (!$group) {
            return response()->json(['error' => 'Group not found.'], 404);
        }

        // Get users in the specified group with their voucher codes
        $users = $group->users()->with('voucherCodes')->orderBy('name')->get();

        $csvData = [['No.', 'Name', 'Voucher Code']];
        $counter = 1;

        foreach ($users as $user) {
            $voucherCodes = $user->voucherCodes;

            foreach ($voucherCodes as $voucherCode) {
                $csvData[] = [$counter++, $user->name, $voucherCode->voucher_code];
            }
        }

        $csvFile = public_path("exports/users_group_{$group->name}.csv");
        $csv = Writer::createFromFileObject(new \SplFileObject($csvFile, 'w+'));
        $csv->insertAll($csvData);

        return $csvFile;
    }
}