<?php


namespace App\Modules\Technic\Facades;


use App\Facades\ModuleFacade;
use App\Models\User;
use App\Modules\Technic\Requests\RegisterRequest;
use App\Services\Service;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Hash;

class TechnicsFacade extends ModuleFacade
{
    protected function model(): string
    {
        return User::class;
    }

    public function getUsersWithRole()
    {
        return $this->model->with('role')->get();
    }

    public function getUserByEncryptedEmail($encryptedEmail)
    {
        $email = Service::decrypt($encryptedEmail);
        return User::where('email', $email)->notActive()->firstOrFail();
    }

    public function registerByEncryptedEmail($data, $encryptedEmail): User
    {
        $data['is_active'] = 1;
        $data['password'] = Hash::make($data['password']);
        $user = $this->getUserByEncryptedEmail($encryptedEmail);
        $user->update($data);
        return $user;
    }
}
