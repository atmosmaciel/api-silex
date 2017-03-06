<?php
/**
 * Esta classe é responsável por sanitizar valores de campos de uso geral.
 */
namespace Api\Service;

class ValidateValues
{
    private $sanitize = array (
         "email" => FILTER_SANITIZE_EMAIL
        ,"encoded" => FILTER_SANITIZE_ENCODED
        ,"magic_quotes" => FILTER_SANITIZE_MAGIC_QUOTES
        ,"number_float" => FILTER_SANITIZE_NUMBER_FLOAT
        ,"number_int" => FILTER_SANITIZE_NUMBER_INT
        ,"special_chars" => FILTER_SANITIZE_SPECIAL_CHARS
        ,"full_special_chars" => FILTER_SANITIZE_FULL_SPECIAL_CHARS
        ,"string" => FILTER_SANITIZE_STRING
        ,"stripped" => FILTER_SANITIZE_STRIPPED
        ,"url" => FILTER_SANITIZE_URL
        ,"unsafe_raw" => FILTER_UNSAFE_RAW
    );

    private function validate_celphone($input)
    {
        return !empty($input) && preg_match('/^[+]?([\d]{0,3})?[\(\.\-\s]?(([\d]{1,3})[\)\.\-\s]*)?(([\d]{3,5})[\.\-\s]?([\d]{4})|([\d]{2}[\.\-\s]?){4})$/', $input);
    }

    public function validateString($slug = null) {
        /*
         * $sanitizedString = $this->sanitize->sanitizeString($slug);
         * $validString = $this->validate->validateString($sanitizedString);
         */
    }

    public function validateName($name = null)
    {
        if (is_null($name) || $name === ''){
            return null;
        } else {
            $rv = is_string($name);

            if (!$rv == true) {
                $valideName = null;
            } else {
                $removingSymbolsNumbers = preg_replace("/[^a-zA-Z\s]/", "", $name);
                $sanitizeValue = filter_var($removingSymbolsNumbers, $this->sanitize['string'], $this->sanitize['full_special_chars']);
                $valideName = $sanitizeValue;
            }
        }

        return $valideName;
    }

    public function validateCelphone($celphone = null)
    {
        if (is_null($celphone)|| $celphone === '') {
            return null;
        } else {

            $sanitizeValue = filter_var($celphone, $this->sanitize['string'], $this->sanitize['full_special_chars']);
            $rv = $this->validate_celphone($sanitizeValue);

            if (!$rv == true) {
                $valideCelphone = null;
            } else {
                $valideCelphone = $rv;
            }
        }

        return $valideCelphone;
    }

    public function validateEmail($email = null)
    {
        if (is_null($email) || $email === '') {
            return null;
        } else {

            $sanitizeValue = filter_var($email, $this->sanitize['email']);
            $valideEmail = filter_var($sanitizeValue, FILTER_VALIDATE_EMAIL);

            if ($valideEmail == false) {
                $valideEmail = null;
            }
        }

        return $valideEmail;
    }

    public function validateWebsite($website)
    {
        if (is_null($website) || $website === '') {
            return null;
        } else {
            $sanitizeValue = filter_var($website, $this->sanitize['url']);
            $valideWebsite = filter_var($sanitizeValue, FILTER_VALIDATE_URL);

            if ($valideWebsite == false) {
                $valideWebsite = null;
            }
        }

        return $valideWebsite;
    }
}
