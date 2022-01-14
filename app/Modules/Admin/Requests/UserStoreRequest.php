<?php

namespace App\Modules\Admin\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name' => ['required', 'max:191'],
            'email' => ['required', 'email:filter', 'unique:users,email', 'max:191'],
            'phone' => ['string', 'max:191'],
            'location' => ['string', 'max:191'],
            'password' => ['required', 'string', 'min:8', 'max:191'],
        ];
    }
}
