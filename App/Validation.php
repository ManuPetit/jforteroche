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
        if (isset($this->errors)){
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
    public function isRequired($inputName, $input){
        if ($input == '') {
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
     * Ensure the text block does not include anyy malicious tags
     * 
     * @param string $input The value to check
     * @return string       The cleaned value    
     */
    public function cleanUpTextBlock($input) {
        return strip_tags(html_entity_decode($input));
        
    }

}
