<?php

namespace App\Http\Requests\DocumentRequests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ShareDocumentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $ownerId = $this->user()->id;
        return [
            'user_id' => ['required', 'exists:users,id', 'not_in:' . $ownerId],
            'permission' => ['required', 'in:edit,view'],
        ];
    }
}
