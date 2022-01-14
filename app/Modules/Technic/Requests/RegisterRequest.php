<?php

namespace App\Modules\Technic\Requests;

use App\Models\User;
use App\Modules\Technic\Facades\TechnicsFacade;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(TechnicsFacade $facade)
    {
        $id = $facade->getUserByEncryptedEmail($this->input('encryptedEmail'))->id;
        return [
            'name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string', 'max:191', 'email:filter', 'unique:users,email,'.$id],
            'phone' => ['required', 'string', 'max:191'],
            'location' => ['required', 'string', 'max:191'],
            'password' => ['required', 'min:8', 'string', 'confirmed']
        ];
    }
}
