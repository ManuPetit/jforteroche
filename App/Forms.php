<?php

/**
 *      Class representing a Form object
 */
class Forms {

    public function __construct() {
        
    }

    /**
     * Method to create a text input to be used in a view. 
     * It calls a generic function to do the work
     * 
     * @param string $name          The name of the input
     * @param string $label         The label show for the input
     * @param bool $required        Set the required attribute. True by default
     * @param string $placeholder   Optional : the text to show on the input placeholder
     * @param array $value          The value of the input if any
     * @param array $error          The error of the input if any
     * @return html                 The completed input field, with values and errors if any
     */
    public function createInputText($name, $label, $required = true, $placeholder = null, $value = null, $errors = null) {
        echo $this->createGenericInput($name, $label, 'text', $required, $placeholder, $value, $errors);
    }

    /**
     * Method to create a password input to be used in a view. 
     * It calls a generic function to do the work
     * 
     * @param string $name          The name of the input
     * @param string $label         The label show for the input
     * @param array $error          The error of the input if any
     */
    public function createPasswordInput($name, $label, $error = null) {
        echo $this->createGenericInput($name, $label, 'password', true, null, null, $errors);
    }

    /**
     * Method to create a textarea in a view. This save doing some messy stuff
     * in a view. All the logic of the input is concentrated in here.
     * 
     * @param string $name          The name of the textarea
     * @param string $label         The label show for the textarea
     * @param bool $required        Set the required attribute. True by default
     * @param string $placeholder   Optional : the text to show on the textarea placeholder
     * @param array $value          The value of the textarea if any
     * @param array $error          The error of the textarea if any
     */
    public function createTextarea($name, $label, $required = true, $placeholder = null, $value = null, $errors = null) {
        $html = "";
        //create the label field
        $html .= "<p>\n<label for=\"$name\">$label :</label><br />\n";
        //create the textarea field
        $html .= "<textarea id=\"$name\" name=\"$name\" rows=\"6\"";
        //check if we have a placeholder
        if (isset($placeholder)) {
            $html .= " placeholder=\"$placeholder\"";
        }
        //check if ield is required
        if ($required) {
            $html .= " required";
        }
        $html .= " />\n";
        //check if we have a value
        if (isset($value[$name])) {
            $html .= $value[$name];
        }
        $html .= "</textarea>";
        //check for the error
        if (isset($errors['err_' . $name])) {
            $html .= '\n<br /><span class="error">Attention : ' . $errors['err_' . $name] . '</span>';
            $html .= "\n";
        }
        $html .= "</p>";
        echo $html;
    }

    /**
     * Method to create a generic input to be used in a view. This save doing some messy stuff
     * in a view. All the logic of the input is concentrated in here.
     * 
     * @param string $name          The name of the input
     * @param string $label         The label show for the input
     * @param string $type          The type of input generated
     * @param bool $required        Set the required attribute. True by default
     * @param string $placeholder   Optional : the text to show on the input placeholder
     * @param array $value          The value of the input if any
     * @param array $error          The error of the input if any
     * @return html                 The completed input field, with values and errors if any
     */
    private function createGenericInput($name, $label, $type, $required = true, $placeholder = null, $value = null, $errors = null) {
        try {
            $html = "";
            //create the label field
            $html .= "<p>\n<label for=\"$name\">$label :</label><br />\n";
            //create the input field
            $html .= "<input id=\"$name\" name=\"$name\" type=\"$type\"";
            //check if we have a placeholder
            if (isset($placeholder)) {
                $html .= " placeholder=\"$placeholder\"";
            }
            //check if we have a value
            if (isset($value[$name])) {
                $html .= " value=\"$value[$name]\"";
            }
            //check if ield is required
            if ($required) {
                $html .= " required";
            }
            $html .= " />\n";
            //check for the error
            if (isset($errors['err_' . $name])) {
                $html .= '<br /><span class="error">Attention : ' . $errors['err_' . $name] . '</span>';
                $html .= "\n";
            }
            $html .= "</p>";
            return $html;
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage());
        }
    }

}
