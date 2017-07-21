<?php

require_once 'App/Model.php';

/**
 *      Class representing a Commentaire object
 */
class Commentaire extends Model {

    //          private properties of the 'Commentaire' object
    private $id;
    private $id_chapter;
    private $id_parent;
    private $user_name;
    private $comment;
    private $id_approval;
    private $date_written;
    //  used for recursiveComments
    private $recursiveComments = [];
    private $level; //level of Comment used in $recursiveComments

    //          Getters and setters
    //  Read only property

    public function getId() {
        return $this->id;
    }

    public function getIdChapter() {
        return $this->id_chapter;
    }

    public function setIdChapter($idChapter) {
        $this->id_chapter = $idChapter;
    }

    public function getIdParent() {
        return $this->id_parent;
    }

    public function setIdParent($idParent) {
        $this->id_parent = $idParent;
    }

    public function getUserName() {
        return $this->user_name;
    }

    public function setUserName($userName) {
        $this->user_name = $userName;
    }

    public function getComment() {
        return $this->comment;
    }

    public function setComment($comment) {
        $this->comment = $comment;
    }

    public function getIdApproval() {
        return $this->id_approval;
    }

    public function setIdApproval($idApproval) {
        $this->id_approval = $idApproval;
    }

    //  Read only property
    //  The output date is formatted to french system
    public function getDateWritten() {
        $timeZone = "Europe/Paris";
        date_default_timezone_set($timeZone);
        $date = date_create($this->date_written);
        return date_format($date, 'd/m/Y à H:i');
    }

    //  Read only property used for tabbed comments
    public function getLevel() {
        return $this->level;
    }

    //          Methods
    /**
     * Methods to retrieve all approved comments for a given chapter
     * 
     * 
     * @param int $idChapter    The ID of chapter 
     * @return array            This is an array of 'Commentaire' object
     *         null             if no comments were found for this chapter 
     */
    public function getApprovedCommentsChapter($idChapter) {
        $sql = "SELECT id, id_chapter, id_parent, user_name, comment, id_approval, date_written FROM comments "
                . "WHERE id_chapter = :idChapter AND id_approval = 2 OR id_approval = 3 ORDER BY date_written";
        $params = array(':idChapter' => $idChapter);
        $rows = $this->getAll($sql, $params);
        if (!empty($rows)) {
            //we call a recursive method to order the comment from parents to child
            unset($this->recursiveComments);
            $this->getRecursiveComments($rows, 0, 0);
            if (isset($this->recursiveComments)) {
                return $this->recursiveComments;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    /**
     * This is a recursive method to classify the comments from parent 
     * to child. We had to the array a level which is used in the view
     * to tab the comment.
     * The array updates the $recursiveComments private property.
     * 
     * @param array $array  The array of comment to be classified
     * @param int $parent   The id of the parent
     * @param int $level    The level of the child
     */
    private function getRecursiveComments($array, $parent, $level = null) {
        if (is_null($level)) {
            $level = 0;
        }
        foreach ($array as $key => $value) {
            if ($value['id_parent'] == $parent) {
                $comment = new Commentaire();
                $comment->id = $value['id'];
                $comment->id_chapter = $value['id_chapter'];
                $comment->id_parent = $value['id_parent'];
                $comment->user_name = $value['user_name'];
                $comment->comment = $value['comment'];
                $comment->id_approval = $value['id_approval'];
                $comment->date_written = $value['date_written'];
                $comment->level = $level;
                $this->recursiveComments[] = $comment;
                $this->getRecursiveComments($array, $value['id'], $level + 1);
            }
        }
    }

    /**
     * Add a new comment in the DB
     * id_approval is set to 1 as a comment needs to be approved by administrator
     * 
     * @param int $idChapter    The ID of the chapter the comment is related to
     * @param string $userName  The name of the person posting the comment
     * @param string $comment   The text of the comment
     * @param int $idParent     The parent id (if a comment is an answer to another one) or
     *                          0 if it is just a comment of the chapter
     */
    public function addComment($idChapter, $userName, $comment, $idParent = null) {
        if (is_null($idParent)) {
            $idParent = 0;
        }
        $sql = "INSERT INTO comments (id_chapter, id_parent, user_name, comment, id_approval, date_written)"
                . " VALUES (:idChapter, :idParent, :userName, :comment, 1, NOW())";
        $params = array(
            ':idChapter' => $idChapter,
            ':idParent' => $idParent,
            'userName' => $userName,
            ':comment' => $comment
        );
        $this->execute($sql, $params);
    }

    /**
     * Method to return an array of Commentaire (except deleted one)
     * 
     * @param int $idApproval   The id approval of the data we want to get back
     * @param int $start        The starting point of the query
     * @param int $display      The number of comment to display
     * @param type $name Description
     * @return array            Array of commentaires
     *         Null     
     */
    public function getAllComments($idApproval, $start, $display) {
        //public function getAllComments($idApproval) {
        if ($idApproval == 1) {
            $inner = 'id_approval = 1';
        } elseif ($idApproval == 2) {
            $inner = 'id_approval = 2';
        } elseif ($idApproval == 3) {
            $inner = 'id_approval = 3';
        } elseif ($idApproval == 4) {
            $inner = 'id_approval = 4';
        } else {
            $inner = 'id_approval <> 5';
        }
        $start = (int) $start;
        $display = (int) $display;
        $sql = "SELECT id, user_name, comment, id_approval, date_written FROM comments "
                . "WHERE $inner ORDER BY id_approval, date_written ASC LIMIT :start, :display";
//        $sql = "SELECT id, user_name, comment, id_approval, date_written FROM comments "
//                . "WHERE $inner ORDER BY id_approval, date_written ASC";
        $params [] = array(
            'name' => ':start',
            'value' => $start,
            'type' => PDO::PARAM_INT
        );
        $params [] = array(
            'name' => ':display',
            'value' => $display,
            'type' => PDO::PARAM_INT
        );
//        $rows = $this->getAll($sql);
        $rows = $this->getAll($sql, $params);
        if (!empty($rows)) {
            $commentaires = array();
            foreach ($rows as $row) {
                $commentaire = new Commentaire();
                $commentaire->id = $row['id'];
                $commentaire->user_name = $row['user_name'];
                $commentaire->comment = $row['comment'];
                $commentaire->id_approval = $row['id_approval'];
                $commentaire->date_written = $row['date_written'];
                $commentaires[] = $commentaire;
            }
            return $commentaires;
        } else {
            return null;
        }
    }

    /**
     * Method to calculate the number of comments
     * depending of their approval
     * 
     * @return array    The comment counts
     */
    public function getTotalCommentDetail() {
        $comments = array();
        $comments['total'] = $this->getNumberComment('all');
        $comments['waiting'] = $this->getNumberComment('waiting');
        $comments['valid'] = $this->getNumberComment('valid');
        $comments['signal'] = $this->getNumberComment('signal');
        $comments['hidden'] = $this->getNumberComment('hidden');
        return $comments;
    }

    /**
     * Method to retrieve the number of comments
     * 
     * @param int $idApproval   The type of comments we search
     * @return int              The total number of comments in the database
     */
    public function getTotalComments($idApproval) {
        switch ($idApproval) {
            case '0':
                $approval = 'all';
                break;
            case '1':
                $approval = 'waiting';
                break;
            case '2':
                $approval = 'valid';
                break;
            case '3':
                $approval = 'signal';
                break;
            case '4':
                $approval = 'hidden';
                break;
            default :
                $approval = 'all';
                break;
        }
        return $this->getNumberComment($approval);
    }

    /**
     * Method to count the number of comment depending
     * of their approval state
     * 
     * @param string $type  The approval type of comment we want
     * @return int
     */
    private function getNumberComment($type) {
        if ($type == 'waiting') {
            $inner = 'id_approval = 1';
        } elseif ($type == 'valid') {
            $inner = 'id_approval = 2';
        } elseif ($type == 'signal') {
            $inner = 'id_approval = 3';
        } elseif ($type == 'hidden') {
            $inner = 'id_approval = 4';
        } else {
            $inner = 'id_approval <> 5';
        }
        $sql = "SELECT COUNT(*) FROM comments WHERE " . $inner;
        return $this->GetOne($sql);
    }

    /**
     * Method to validate a comment
     * 
     * @param int $idComment    The ID of the comment we want to validate
     */
    public function validateComment($idComment) {
        $this->setCommentApproval($idComment, 'validate');
    }

    /**
     * Signal a comment and retrieve the chapter ID
     * 
     * @param int $idComment    The ID of the comment we want to signal
     * @return int              The id of the chapter related to this comment
     */
    public function signalComment($idComment) {
        //update the table
        $this->setCommentApproval($idComment, 'signal');
        //retrieve chapter id
        $sql = "SELECT id_chapter FROM comments WHERE id= :idComment";
        $params = array(':idComment' => $idComment);
        return $this->GetOne($sql, $params);
    }

    /**
     * Method to hide a comment
     * 
     * @param int $idComment    The ID of the comment we want to hide
     */
    public function hideComment($idComment) {
        $this->setCommentApproval($idComment, 'hide');
    }

    /**
     * Method to delete a comment
     * 
     * @param int $idComment    The ID of the comment we want to delete
     */
    public function deleteComment($idComment) {
        $this->setCommentApproval($idComment, 'delete');
    }

    /**
     * Method to set the value of approval of a comment
     * 
     * @param int $idComment    The ID of the comment we want to set
     * @param string $$approval The type of approval
     */
    private function setCommentApproval($idComment, $approval) {
        if ($approval == 'validate') {
            $inner = 2;
        } elseif ($approval == 'signal') {
            $inner = 3;
        } elseif ($approval == 'hide') {
            $inner = 4;
        } elseif ($approval == 'delete') {
            $inner = 5;
        } else {
            $inner = 1;
        }
        $sql = "UPDATE comments SET id_approval = $inner WHERE id = :id";
        $param = array(':id' => $idComment);
        $this->execute($sql, $param);
    }

}
