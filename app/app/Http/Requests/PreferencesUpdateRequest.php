<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Models\UserSetting;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PreferencesUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'theme' => ['required', Rule::in('dark', 'light')]
        ];
    }
}
