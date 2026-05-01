<?php

namespace App\Http\Requests\FolderRequests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateFolderRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $folder = $this->route('folder');
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('folders', 'name')->where('user_id', $this->user()->id)->ignore($folder->id)],
        ];
    }
}
