<?php

namespace App\Modules\Admin\Requests;

use App\Modules\Admin\Facades\UsersFacade;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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

        $path = explode("/", $this->path());
        $id = end($path);
        return [
            'name' => ['required', 'max:191'],
            'email' => ['required', 'max:191', 'email:filter', 'unique:users,email,'.$id],
            'phone' => ['string', 'max:191'],
            'location' => ['string', 'max:191'],
        ];
    }
}
