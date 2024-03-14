<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MyURL implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->isValidUrl($value)) {
            $fail(':attribute must be a valid URL.');
        }
    }

    public function isValidUrl(string $candidate) : bool
    {
        $result = preg_match('/(https?:\/\/)?(www\.)?([-a-zA-Z0-9@:%._\+~#=]{1,256})\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&\/\/=]*)/', $candidate, $output);

        return $result === 1;
    }
}
