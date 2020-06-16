<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class SaveRequest extends FormRequest
{
    private $primaryRules = [
        'name' => 'required|string|max:40',
    ];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (!$this->isRegister())
            return $this->user()->can('update', $this->route('user'));
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->isRegister())
            return array_merge($this->primaryRules, [
                'email' => 'required|email',
                'password' => 'required|string|min:6',
                'password_confirmation' => 'required|string|min:6',
            ]);

        return $this->primaryRules;
    }

    /**
     * Checks if this is a register route.
     *
     * @return boolean
     */
    private function isRegister()
    {
        return Str::contains(Route::currentRouteName(), 'auth.');
    }
}
