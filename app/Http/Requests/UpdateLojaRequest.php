<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLojaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $id = $this->route('id');
        return [
            'nome' => 'required|min:3|max:40',
            'email' => [
                'required', 'email',
                Rule::unique('lojas', 'email')->where(fn ($query) => $query->where('id', '!=', $id))
            ]
        ]
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => $validator->errors(),
            'status' => 'error',
            'type' => 'validation'
        ], 400));
    }
}
