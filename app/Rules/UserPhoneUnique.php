<?php

namespace App\Rules;

use App\Services\UserService;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UserPhoneUnique implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $unmaskedValue = preg_replace('/\D/', '', $value);

        if ($unmaskedValue === null) {
            $fail(__('validation.required'));
            return;
        }

        if (UserService::firstUserWhen('phone', $unmaskedValue) !== null) {
            $fail(__('validation.unique', ['attribute' => $attribute]));
        }

        return;
    }
}
