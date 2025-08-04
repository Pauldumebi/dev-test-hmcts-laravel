<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Carbon\Carbon;

class DueDateRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $value)) {
            $fail("The {$attribute} must be in the format d/m/YYYY.");
            return;
        }

        $dt = Carbon::createFromFormat('j/n/Y', $value);
        $parseErrors = Carbon::getLastErrors();

        if ($parseErrors['warning_count'] > 0 || $parseErrors['error_count'] > 0) {
            $fail("The {$attribute} must be a valid calendar date.");
            return;
        }

        if ($dt->startOfDay()->lt(Carbon::today())) {
            $fail("The {$attribute} must be today or a future date.");
            return;
        }
    }
}
