<?php


namespace App\Modules\Admin\Facades;


use App\Facades\ModuleFacade;
use App\Models\Role;
use App\Models\User;
use App\Modules\Admin\Requests\UserStoreRequest;
use App\Modules\Admin\Requests\UserUpdateRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class UsersFacade extends ModuleFacade
{
    protected function model(): string
    {
        return User::class;
    }

    /**
     * @return mixed
     */
    public function getTechnicians()
    {
        return $this->model->where('role_id', Role::ROLE_TECHNICIAN)->get();
    }

    /**
     * @param string $deleted
     * @return mixed
     */
    public function technicians(string $deleted = '')
    {
        return ($deleted)
            ? $this->model->where('role_id', Role::ROLE_TECHNICIAN)->onlyTrashed()
            : $this->model->where('role_id', Role::ROLE_TECHNICIAN);
    }

    /**
     * @param string $name
     * @param string $email
     * @return User|null
     */
    public function storeUserWithInvite(string $name, string $email): ?User
    {
        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'role_id' => Role::ROLE_TECHNICIAN
            ]);
            $this->sendInvite($name, $email);
            DB::commit();
            return $user;
        } catch (QueryException $e) {
            DB::rollBack();
            Log::error('Creating and inviting user with email: ' . $email);
        }
    }

    /**
     * @param $data
     * @return User
     */
    public function create($data): User
    {
        $data['role_id'] = Role::ROLE_TECHNICIAN;
        $data['password'] = Hash::make($data['password']);
        $data['is_active'] = true;
        return $this->model->create($data);
    }

    /**
     * @param string $to_name
     * @param string $to_email
     */
    public function sendInvite(string $to_name, string $to_email)
    {
        $data['encryptedEmail'] = encrypt($to_email);
        $data['name'] = $to_name;
        Mail::send('mails.invitation', $data, function ($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)->subject(config('app.name'));
            $message->from(config('mail.from.address'), config('mail.from.name'));
        });
    }

    /**
     * @param $data
     * @param User $user
     * @return bool
     */
    public function update($data, User $user): bool
    {
        return $user->update($data);
    }

    /**
     * @param int $id
     */
    public function restore(int $id)
    {
        $user = $this->onlyTrashed()->findOrFail($id);
        try {
            $this->authorize('restore', $user);
        } catch (AuthorizationException $e) {
            Log::error(auth()->user()->email. ' tried to restore the user with id: ' . $id);
        }
        $user->restore();
        $user->save();
    }

    /**
     * @return mixed
     */
    public function onlyTrashed()
    {
        return $this->model->onlyTrashed();
    }
}
