<?php

/**
 *      Class representing a Form object
 * 
 *      This class specialise in creating various form object to ensure the views are not overcomplicated 
 *      with conditions and loops and PHP.
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
     * Method to create a large text input to be used in a view. 
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
    public function createLargeInputText($name, $label, $required = true, $placeholder = null, $value = null, $errors = null) {
        echo $this->createGenericInput($name, $label, 'text', $required, $placeholder, $value, $errors, true);
    }

    /**
     * Method to create a email input to be used in a view. 
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
    public function createInputEmail($name, $label, $required = true, $placeholder = null, $value = null, $errors = null) {
        echo $this->createGenericInput($name, $label, 'email', $required, $placeholder, $value, $errors);
    }

    /**
     * Method to create a password input to be used in a view. 
     * It calls a generic function to do the work
     * 
     * @param string $name          The name of the input
     * @param string $label         The label show for the input
     * @param array $error          The error of the input if any
     */
    public function createInputPassword($name, $label, $errors = null) {
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
        $html .= ">\n";
        //check if we have a value
        if (isset($value[$name])) {
            $html .= $value[$name];
        }
        $html .= "</textarea>";
        //check for the error
        if (isset($errors['err_' . $name])) {
            $html .= '\n<br /><span class="error">Attention : ' . $errors['err_' . $name] . '</span>';
        }
        $html .= "\n</p>\n";
        echo $html;
    }

    /**
     * Creates a tinymce textArea
     * 
     * @param string $name          The name of the textarea
     * @param string $label         The label show for the textarea
     * @param bool $required        Set the required attribute. True by default
     * @param array $value          The value of the textarea if any
     * @param array $error          The error of the textarea if any
     */
    public function createTinymceTextarea($name, $label, $required = true, $value = null, $errors = null) {
        $html = "";
        //create the label field
        $html .= "<p>\n<label for=\"$name\">$label :</label><br />\n";
        //create the textarea field
        $html .= "<textarea id=\"$name\" name=\"$name\" class=\"tinymce\"";
        //check if ield is required
        if ($required) {
            $html .= " required";
        }
        $html .= ">\n";
        //check if we have a value
        if (isset($value[$name])) {
            $html .= $value[$name];
        }
        $html .= "</textarea>";
        //check for the error
        if (isset($errors['err_' . $name])) {
            $html .= '\n<br /><span class="error">Attention : ' . $errors['err_' . $name] . '</span>';
        }
        $html .= "\n</p>\n";
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
     * @param bool $large            1 if this is a large input
     * @return html                 The completed input field, with values and errors if any
     */
    private function createGenericInput($name, $label, $type, $required = true, $placeholder = null, $value = null, $errors = null, $large = false) {
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
            // check if is large
            if ($large == true) {
                $html .= ' class="large"';
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
            $html .= "</p>\n";
            return $html;
        } catch (Exception $ex) {
            throw new Exception($ex);
        }
    }

    /**
     * Method to create a row from a chapter depending of the id_state
     * It then echo the result or throw an error
     * 
     * @param Chapitre $chapter The chapter we want to see on that row.
     */
    public function createChapterRow($chapter) {
        $html = "";
        try {
            //create view action
            $actions = '<a href="admin/modifier/' . $chapter->getId() . '" title="Cliquez ici pour voir cet épisode"><span class="fa fa-eye" aria-hidden="true"></span></a>';
            //selecting the color of the chapter title depending on the state
            //and adding correct actions
            if ($chapter->getIdState() == 1) {
                $textColor = 'editing';
                $actions .= '<span class="fa fa-pencil" aria-hidden="true"></span>';
                $actions .= '<a href="admin/publier/' . $chapter->getId() . '" title="Cliquez ici pour publier cet épisode"><span class="fa fa-file-text" aria-hidden="true"></span></a>';
            } else {
                $textColor = 'published';
                $actions .= '<a href="admin/editer/' . $chapter->getId() . '" title="Cliquez ici pour remettre cet épisode en brouillon"><span class="fa fa-pencil" aria-hidden="true"></span></a>';
                $actions .= '<span class="fa fa-file-text" aria-hidden="true"></span>';
            }
            //add delete action
            $actions .= '<a href="admin/effacer/' . $chapter->getId() . '" onclick="return confirm(\'Etes vous certain de vouloir suprimer ce chapitre?\')" title="Cliquez ici pour supprimer cet épisode"><span class="fa fa-trash" aria-hidden="true"></span></a>';
            $html .= '<tr><td class="' . $textColor . '">' . $this->sanitizeHtml($chapter->getTitle()) . '</td><td class="links">';
            $html .= $actions;
            $html .= '</td></tr>';
            $html .= "\n";
            echo $html;
        } catch (Exception $ex) {
            throw new Exception($ex);
        }
    }

    /**
     * Method to create a row from a commentaire depending of the id_approval
     * It then echo the result or throw an error
     * 
     * @param Commentaire $comment  The comment we need to see on that row
     */
    public function createMessageRow($comment) {
        $html = "";
        try {
            //create the text color
            switch ($comment->getidApproval()) {
                case 1:
                    $textColor = 'waiting';
                    break;
                case 2:
                    $textColor = 'validated';
                    break;
                case 3:
                    $textColor = 'signaled';
                    break;
                case 4:
                    $textColor = 'hidden';
                    break;
                default :
                    $textColor = 'validated';
            }
            //create view action
            if ($comment->getIdApproval() == 4) {
                $actions = '<a href="admin/valider/' . $comment->getId() . '" title="Cliquez ici pour valider ce commentaire"><span class="fa fa-check" aria-hidden="true"></span></a>';
                $actions .= '<span class="fa fa-low-vision" aria-hidden="true"></span>';
            } elseif ($comment->getIdApproval() == 2) {
                $actions = '<span class="fa fa-check" aria-hidden="true"></span></a>';
                $actions .= '<a href="admin/masquer/' . $comment->getId() . '" title="Cliquez ici pour masquer ce commentaire"><span class="fa fa-low-vision" aria-hidden="true"></span>';
            } else {
                $actions = '<a href="admin/valider/' . $comment->getId() . '" title="Cliquez ici pour valider ce commentaire"><span class="fa fa-check" aria-hidden="true"></span></a>';
                $actions .= '<a href="admin/masquer/' . $comment->getId() . '" title="Cliquez ici pour masquer ce commentaire"><span class="fa fa-low-vision" aria-hidden="true"></span>';
            }
            $actions .= '<a href="admin/supprimer' . $comment->getId() . '" onclick="return confirm(\'Etes vous certain de vouloir suprimer ce commentaire?\')" title="Cliquez ici pour supprimer ce commentaire"><span class="fa fa-trash" aria-hidden="true"></span></a>';
            $html .= '<tr><td class="' . $textColor . '">Message de <em>' . $this->sanitizeHtml($comment->getUserName()) . '</em> en date du ';
            $html .= $comment->getDateWritten() . '<br/><span class="com-color">"' . $this->sanitizeHtml($comment->getComment()) . '"</span>';
            $html .= '</td><td class="links">';
            $html .= $actions;
            $html .= '</td></tr>';
            $html .= "\n";
            echo $html;
        } catch (Exception $ex) {
            throw new Exception($ex);
        }
    }

    /**
     * Method to show on the screen the count of chapters
     * 
     * @param array $chapters   Array of chapter counts by id state
     */
    public function createChaptersCount($chapters) {
        $html = "";
        try {
            if ($chapters['total'] == 0) {
                $html .= "<p>Il n'y a encore aucun chapitre d'écrit.</p>";
            } else {
                $html = '<table>';
                $plural = ($chapters['total'] > 1) ? 's' : '';
                $html .= '<tr><td>Nombre total de chapitre' . $plural . '</td><td class="numbers">' . $chapters['total'] . '</td></tr>';
                $plural = ($chapters['publish'] > 1) ? 's' : '';
                $html .= '<tr><td>Nombre de chapitre' . $plural . ' publié' . $plural . '</td><td class="numbers">' . $chapters['publish'] . '</td></tr>';
                $plural = ($chapters['edit'] > 1) ? 's' : '';
                $html .= '<tr><td>Nombre de chapitre' . $plural . ' en brouillon</td><td class="numbers">' . $chapters['edit'] . '</td></tr>';
                $html .= '</table>';
            }
            echo $html;
        } catch (Exception $ex) {
            throw new Exception($ex);
        }
    }

    /**
     * Method to show on the screen the count of comments
     * 
     * @param array $comments   Array of comment counts by id approval
     */
    public function createMessageCount($comments) {
        $html = "";
        try {
            if ($comments['total'] == 0) {
                $html .= '<p>Aucun message n\'a été ecrit.</p>';
            } else {
                $html = '<table>';
                $plural = ($comments['total'] > 1) ? 's' : '';
                $html .= '<tr><td>Nombre total de message' . $plural . '</td><td class="numbers">' . $comments['total'] . '</td></tr>';
                $plural = ($comments['waiting'] > 1) ? 's' : '';
                $html .= '<tr><td>Nombre de message' . $plural . ' en attente de validation</td><td class="numbers">' . $comments['waiting'] . '</td></tr>';
                $plural = ($comments['valid'] > 1) ? 's' : '';
                $html .= '<tr><td>Nombre de message' . $plural . ' validé' . $plural . '</td><td class="numbers">' . $comments['valid'] . '</td></tr>';
                $plural = ($comments['signal'] > 1) ? 's' : '';
                $html .= '<tr><td>Nombre de message' . $plural . ' signalé' . $plural . ' par les lecteurs</td><td class="numbers">' . $comments['signal'] . '</td></tr>';
                $plural = ($comments['hidden'] > 1) ? 's' : '';
                $html .= '<tr><td>Nombre de message' . $plural . ' masqué' . $plural . '</td><td class="numbers">' . $comments['hidden'] . '</td></tr>';
                $html .= '</table>';
            }
            echo $html;
        } catch (Exception $ex) {
            throw new Exception($ex);
        }
    }

    //cleans up html input
    private function sanitizeHtml($value) {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8', false);
    }

    /**
     * Generates the pagination on the messages view
     * 
     * @param int $start    The starting page 
     * @param int $pages    The total number of pages
     * @param int $display  The number of message per pages
     * @param int $option   The approval ID
     */
    public function createPagination($start, $pages, $display, $option, $prevoption) {
        $html = "";
        try {
            if ($pages > 1) {
                $html .= '<tr><td colspan="2" class="paging">';
                $currentPage = ($start / $display) + 1;
                //not the first page so we make a previous link
                if ($currentPage != 1) {
                    $html .= '<a href="admin/messages/0/start/' . ($start - $display) . '/pages/' . $pages . '/approval/' . $option . '/prevoption/' . $prevoption;
                    $html .= '" title="Allez à la page précédente">Préc.</a>';
                }
                //make all the numbered pages
                for ($i = 1; $i <= $pages; $i++) {
                    if ($i != $currentPage) {
                        $html .= '<a href="admin/messages/0/start/' . ($display * ($i - 1)) . '/pages/' . $pages . '/approval/' . $option . '/prevoption/' . $prevoption;
                        $html .= '" title="Allez à la page ' . $i . '">' . $i . '</a>';
                    } else {
                        $html .= '<span>' . $i . '</span>';
                    }
                }
                //make the last link if not on the last page
                if ($currentPage != $pages) {
                    $html .= '<a href="admin/messages/0/start/' . ($start + $display) . '/pages/' . $pages . '/approval/' . $option . '/prevoption/' . $prevoption;
                    $html .= '" title="Allez à la page suivante">Suiv.</a>';
                }
                $html .= '</td></tr>';
                echo $html;
            }
        } catch (Exception $ex) {
            throw new Exception($ex);
        }
    }

}
