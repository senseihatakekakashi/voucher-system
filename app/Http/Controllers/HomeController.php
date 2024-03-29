<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class HomeController
 *
 * Controller for handling home redirection based on user roles.
 *
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * Redirect authenticated users based on their roles.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
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

        // Default redirection (modify as needed)
        return redirect()->route('login');
    }
}
