<?php

namespace App\Services;

use League\Csv\Writer;

/**
 * Class ExportCSVService
 *
 * This class provides functionality to export data to CSV files.
 *
 * @package App\Services
 */
class ExportCSVService
{
    /**
     * Export all users and their voucher codes to a CSV file.
     *
     * @param \Illuminate\Database\Eloquent\Collection $model The collection of users.
     *
     * @return string The path to the generated CSV file.
     */
    public function exportAll($model)
    {
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

    /**
     * Export users in a specific group and their voucher codes to a CSV file.
     *
     * @param \App\Models\Group $group The group to export users from.
     *
     * @return string|\Illuminate\Http\JsonResponse The path to the generated CSV file or an error response.
     */
    public function exportGroupUsers($group)
    {
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