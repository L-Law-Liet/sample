<?php

namespace App\Modules\Product\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
        return array_merge([
            'location' => ['required', 'string', 'max:191'],
            'reported_by' => ['required', 'string', 'max:191'],
            'serial' => ['string', 'max:191'],
            'images' => ['array'],
            'description' => ['required', 'string', 'max:1000'],
            'parts' => ['required', 'string', 'max:1000'],
            'client_id' => ['required', 'exists:clients,id'],
            'problem_type_id' => ['required', 'exists:problem_types,id'],
            'category_id' => ['required', 'exists:clients,id'],
            'product_status_id' => ['required', 'exists:product_statuses,id'],
        ], (new CommentsRequest)->rules());
    }
}
