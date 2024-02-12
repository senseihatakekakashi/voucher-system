<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function redirectTo()
    {
        // Customize redirection based on user role
        if (auth()->user()->hasRole('super-admin')) {
            return redirect()->route('group-admins.index');
        } elseif (auth()->user()->hasRole('group-admin')) {
            return redirect()->route('groups.index');
        } elseif (auth()->user()->hasRole('users')) {
            return redirect()->route('voucher-codes.index');
        }
    }
}
