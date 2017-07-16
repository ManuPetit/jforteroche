<?php

/**
 *      Class representing a Validation object
 */
class Validation {

    //          Private property
    private $errors = [];

    /**
     * This class help for the validation of the input. It set errors
     * in an array which will be used later if it exists
     */
    public function __construct() {
        unset($this->errors);
    }

    public function getErrors() {
        if (isset($this->errors)) {
            return $this->errors;
        } else {
            return null;
        }
    }

    /**
     * Check if an input which is required is not empty
     * 
     * @param string $inputName The name of the input the value comes from
     * @param string $input     The value to check
     */
    public function isRequired($inputName, $input) {
        if (trim($input) == '') {
            $this->errors['err_' . $inputName] = "vous devez entrer une valeur dans ce champs.";
        }
    }

    /**
     * Check if an value send is a range of alphanumeric characters
     * 
     * @param string $inputName The name of the input the value comes from
     * @param string $input     The value to check
     * @param int $minSize      The minimum size: 3 is the default
     * @param int $maxSize      The maximum size or 0 for very long text
     * @return boolean          True if it matches
     *                          otherwise an error message is generated
     */
    public function isAlphaNumInputOk($inputName, $input, $minSize = 3, $maxSize = 0) {
        if ($maxSize != 0) {
            if (!preg_match('#^[a-zA-Z0-9_ éèêêçàùîïô]{' . $minSize . ',' . $maxSize . '}$#', $input)) {
                $this->errors['err_' . $inputName] = "lettres ou chiffres uniquement, de $minSize à $maxSize caractères.";
            }
        } else {
            if (!preg_match('#^[a-zA-Z0-9_ éèêêçàùîïô]{' . $minSize . ',}$#', $input)) {
                $err = "lettres ou chiffres uniquement. Minimum $minSize caractère";
                $plural = ($minSize > 1) ? 's.' : '.';
                $err .= $plural;
                $this->errors['err_' . $inputName] = $err;
            }
        }
    }

    /**
     * cleanup text and check that it is of the right size
     * 
     * @param string $inputName The name of the input the value comes from
     * @param string $input     The value to check
     * @param int $minSize      The minimum size: 3 is the default
     * @param int $maxSize      The maximum size or 0 for very long text
     * @return string           return cleanup text
     */
    public function cleanUpText($inputName, $input, $minSize = 3, $maxSize = 0) {
        $input = trim($input);
        if (strlen($input) < $minSize) {
            $this->errors['err_' . $inputName] = "minimum $minSize charactères";
        }
        if (strlen($input) > $maxSize) {
            $this->errors['err_' . $inputName] = "maximum $maxSize charactères";
        }
        //clean up text
        return $this->cleanUpTextBlock($input);
    }

    /**
     * Ensure the text block does not include anyy malicious tags
     * 
     * @param string $input The value to check
     * @return string       The cleaned value    
     */
    public function cleanUpTextBlock($input) {
        return strip_tags(html_entity_decode($input));
    }

    /**
     * Method to allow only certains tags in tinymce
     * 
     * @param string $input The value to check
     * @return string       The cleaned value 
     */
    public function cleanUpTinyMce($input) {
        $input = trim($input);
        $allowedTags = '<p><strong><em><u><h1><h2><h3><h4><h5><h6>';
        $allowedTags .= '<li><ol><ul><span><div><br><ins><del>';
        return strip_tags(stripcslashes($input), $allowedTags);
        //return strip_tags($input, $allowedTags);
    }

    /**
     * Method to check we have a valid email address
     * 
     * @param string $inputName The name of the input the value comes from
     * @param string $input     The value to check
     */
    public function isValidEmail($inputName, $input) {
        $input = trim($input);
        if (!preg_match('#^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$#i', $input)) {
            $this->errors['err_' . $inputName] = "adresse email non valide";
        }
    }
    
    /**
     * Method to check a password meets the minimum requirements
     * 
     * @param string $inputName The name of the input the value comes from
     * @param string $input     the value to check
     */
    public function isPasswordChecked($inputName, $input){
        $input = trim($input);
        if (!preg_match('#^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])\w{6,30}$#', $input)){
            $this->errors['err_' . $inputName] = "le mot de passe doit contenir entre 8 et 30 caractères (chiffres, lettres minuscules et majuscules)";
        }
    }
    
    /**
     * Method to check the two new password are the same
     * 
     * @param string $inputName The name of the input the value comes from
     * @param string $passOne   the first value to check
     * @param string $passTwo   the second value to check
     */
    public function isPasswordMatched($inputName, $passOne, $passTwo){
        $passOne = trim($passOne);
        $passTwo = trim($passTwo);
        if ($passOne != $passTwo){
            $this->errors['err_' . $inputName] = "le mot de passe ne correspond pas à la confirmation du mot de passe";
        }
    }

}
