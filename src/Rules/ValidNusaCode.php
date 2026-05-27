<?php

namespace Vernsg\NusaFilament\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Vernsg\NusaFilament\Support\NusaOptions;
use Vernsg\NusaFilament\Support\NusaRegion;

class ValidNusaCode implements ValidationRule
{
    public function __construct(private readonly NusaRegion $region) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! NusaOptions::exists($this->region, $value)) {
            $fail('validation.exists')->translate();
        }
    }
}
