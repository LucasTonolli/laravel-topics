<?php

namespace App\Http\Requests\DocumentRequests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->route('folder')->user_id === $this->user()->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $mimeTypes = implode(',', config('docvault.allowed_file_types'));
        $maxSize = config('docvault.max_upload_size');

        return [
            'name' => ['required', 'string', 'max:255'],
            'document' => ['required', 'file', 'mimes:' . $mimeTypes, 'max:' . $maxSize * 1024],
        ];
    }
}
