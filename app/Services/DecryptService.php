<?php

namespace App\Services;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

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