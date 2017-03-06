<?php

namespace Api\Service\SanitizerValidatorValues;

class ValidateValues
{
    private $sanitize;
    private $validate;

    public function __construct()
    {
        $this->sanitize = new Sanitize();
        $this->validate = new Validate();
    }

    public function string($input = null)
    {
        $sanitizedString = $this->sanitize->string($input);
        if ($sanitizedString == false) return $sanitizedString;
        return $validString = $this->validate->string($sanitizedString);
    }

    public function phone($input = null)
    {
        $sanitizedString = $this->sanitize->string($input);
        if ($sanitizedString == false) return $sanitizedString;
        return $validPhone = $this->validate->phone($sanitizedString);
    }

    public function email($input = null)
    {
        $sanitizedEmail = $this->sanitize->email($input);
        if ($sanitizedEmail == false) return $sanitizedEmail;
        return $validEmail = $this->validate->email($sanitizedEmail);
    }

    public function url($input = null)
    {
        $sanitizedUrl = $this->sanitize->url($input);
        if ($sanitizedUrl == false) return $sanitizedUrl;
        return $validUrl = $this->validate->url($sanitizedUrl);
    }
}
