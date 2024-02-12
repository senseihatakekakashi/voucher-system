<?php

namespace App\Services;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class DecryptService
{
    public function decrypt($id) {
        try {
            return Crypt::decryptString($id);    
        } catch (DecryptException $e) {
            abort(404);
        }
    }
}