<?php

namespace Modules\Admin\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;
    public function __construct()
    {
        $this->middleware('guest:admin');
    }

    public function showLinkRequestForm() {
        return view('Dashboard.auth.passwords.email');
    }

    protected function broker() {
        return Password::broker('admins');
    }
}
