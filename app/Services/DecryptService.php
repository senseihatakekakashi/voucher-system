<?php

namespace App\Services;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

/**
 * Class DecryptService
 *
 * This class provides a service for decrypting encrypted values using Laravel's Crypt facade.
 *
 * @package App\Services
 */
class DecryptService
{
    /**
     * Decrypt the given encrypted value.
     *
     * @param string $id The encrypted value to be decrypted.
     *
     * @return mixed The decrypted value.
     */
    public function decrypt($id)
    {
        try {
            return Crypt::decryptString($id);
        } catch (DecryptException $e) {
            abort(404);
        }
    }
}