<?php

namespace App\Modules\Technic\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Technic\Facades\TechnicsFacade;
use App\Modules\Technic\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;

class TechnicController extends Controller
{
    private $facade;

    public function __construct(TechnicsFacade $technicsFacade)
    {
        $this->facade = $technicsFacade;
    }

    public function showRegistration($encryptedEmail)
    {
        $user = $this->facade->getUserByEncryptedEmail($encryptedEmail);
        return view('auth.register', compact('user', 'encryptedEmail'));
    }

    public function register(RegisterRequest $request, $encryptedEmail)
    {
        $user = $this->facade->registerByEncryptedEmail($request->validated(), $encryptedEmail);
        Auth::login($user);
        return redirect()->route('profile.show');

    }
}
