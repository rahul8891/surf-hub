<?php

namespace App\Traits;

use Laravel\Fortify\Rules\Password;

trait PasswordTrait
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array
     */
    protected function passwordRules()
    {
        return ['required', 'string', new Password, 'confirmed'];
    }
}