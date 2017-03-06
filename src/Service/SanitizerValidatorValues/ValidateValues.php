<?php

namespace Api\Service;

use Api\Service\SanitizerValidatorValues\Sanitize;
use Api\Service\SanitizerValidatorValues\Validate;

class ValidateValues
{
    private $sanitize;
    private $validate;

    public function __construct()
    {
        $this->sanitize = new Sanitize();
        $this->validate = new Validate();
    }

    public function string($input = null) {

        $sanitizedString = $this->sanitize->string($input);
        $validString = $this->validate->string($sanitizedString);

        return $validString;

    }

    public function phone($input = null)
    {
        $sanitizedString = $this->sanitize->string($input);
        $validPhone = $this->validate->phone($sanitizedString);

        return $validPhone;
    }

    public function email($input = null)
    {
        $sanitizedEmail = $this->sanitize->email($input);
        $validEmail = $this->validate->email($sanitizedEmail);

        return $validEmail;
    }

    public function url($input = null)
    {
        $sanitizedUrl = $this->sanitize->url($input);
        $validUrl = $this->validate->url($sanitizedUrl);

        return $validUrl;
    }
}
