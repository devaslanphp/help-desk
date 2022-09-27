<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{

    public function __invoke(Request $request)
    {
        Auth::logout();
        $request->session()->regenerateToken();
        return redirect('/');
    }

}
