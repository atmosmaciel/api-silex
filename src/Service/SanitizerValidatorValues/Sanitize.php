<?php

namespace Api\Service\SanitizerValidatorValues;

class Sanitize
{
    public function stringSpecialCaracteres($slug = null) {
        $stringSpecial = filter_var($slug, FILTER_SANITIZE_FULL_SPECIAL_CHARS); return $stringSpecial;
    }

    public function string($slug = null)
    {
        $string = filter_var($slug, FILTER_SANITIZE_STRING);
        return $sanitizeString = filter_var($this->stringSpecialCaracteres($string));
    }

    public function email($slug = null) {
        return $email = filter_var($slug, FILTER_SANITIZE_EMAIL);
    }

    public function url($slug = null) {
        return $url = filter_var($slug, FILTER_SANITIZE_URL);
    }

}
