<?php

require_once 'App/Model.php';

/**
 *      Class representing a Chapitre object
 */
class Chapitre extends Model {

    //          private properties of the 'Chapitre' model
    private $id;
    private $title;
    private $content;
    private $id_user;
    private $user_name;
    private $id_state;
    private $date_last_modif;

    //          Getters and setters
    //  Read only property
    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle( $title) {
        $this->title = $title;
    }

    public function getContent() {
        return $this->content;
    }

    public function setContent( $content) {
        $this->content = $content;
    }

    public function getIdUser() {
        return $this->id_user;
    }

    public function setIdUser( $idUser) {
        $this->id_user = $idUser;
    }

    //  Read only property
    public function getUserName() {
        return $this->user_name;
    }

    public function getIdState() {
        return $this->id_state;
    }

    public function setIdState( $idState) {
        $this->id_state = $idState;
    }

    //  Read only property
    //  The output date is formatted to french system
    public function getDateLastModif() {
        $timeZone = "Europe/Paris";
        date_default_timezone_set($timeZone);
        $date = date_create($this->date_last_modif);
        return date_format($date, 'd/m/Y');
    }

    //          Methods
    /**
     * Method to set a published chapter depending of the id of that chapter
     * 
     * @param int $idChapter    the ID of the chapter
     * @throws Exception
     */
    public function getPublishedChapter( $idChapter) {
        $sql = "SELECT chapters.id as id, title, content, chapters.id_user as id_user, CONCAT(name, ' ', surname) as user_name,"
                . "  id_state, date_last_modif "
                . "FROM chapters INNER JOIN users ON chapters.id_user = users.id"
                . " WHERE chapters.id = :id AND id_state = 2";
        $params = array(':id' => $idChapter);
        $row = array();
        $row = $this->getRow($sql, $params);
        if (!empty($row)) {
            $this->id = $row['id'];
            $this->title = $row['title'];
            $this->content = $row['content'];
            $this->id_user = $row['id_user'];
            $this->user_name = $row['user_name'];
            $this->id_state = $row['id_state'];
            $this->date_last_modif = $row['date_last_modif'];
        } else {
            throw new Exception("Chapitre invalide...");
        }
    }

    /**
     * Method to set a chapter depending of the id of that chapter
     * 
     * @param int $idChapter    the ID of the chapter
     * @throws Exception
     */
    public function getChapter( $idChapter) {
        $sql = "SELECT chapters.id as id, title, content, chapters.id_user as id_user, CONCAT(name, ' ', surname) as user_name,"
                . "  id_state, date_last_modif "
                . "FROM chapters INNER JOIN users ON chapters.id_user = users.id"
                . " WHERE chapters.id = :id AND id_state <> 3";
        $params = array(':id' => $idChapter);
        $row = array();
        $row = $this->getRow($sql, $params);
        if (!empty($row)) {
            $this->id = $row['id'];
            $this->title = $row['title'];
            $this->content = $row['content'];
            $this->id_user = $row['id_user'];
            $this->user_name = $row['user_name'];
            $this->id_state = $row['id_state'];
            $this->date_last_modif = $row['date_last_modif'];
        } else {
            throw new Exception("Chapitre invalide...");
        }
    }
    
    /**
     * Method to retrieve the last chapters published (3 max)
     * 
     * @return array    this is an array of 'Chapitre' object.
     *         null     if no chapters have been published
     */
    public function getLastPublishedChapters() {
        $sql = "SELECT chapters.id, title, CONCAT(SUBSTRING_INDEX(content, '.',4),'...') as content, "
                . " chapters.id_user as id_user, CONCAT(name, ' ', surname) as user_name, id_state, date_last_modif FROM chapters "
                . "INNER JOIN users ON chapters.id_user = users.id INNER JOIN states ON chapters.id_state=states.id "
                . "WHERE id_state = 2 ORDER BY date_last_modif DESC LIMIT 3 ";
        $rows = $this->getAll($sql);
        if (!empty($rows)) {
            $chapters = array();
            foreach ($rows as $row) {
                $chapter = new Chapitre();
                $chapter->id = $row['id'];
                $chapter->title = $row['title'];
                $chapter->content = $row['content'];
                $chapter->id_user = $row['id_user'];
                $chapter->user_name = $row['user_name'];
                $chapter->id_state = $row['id_state'];
                $chapter->date_last_modif = $row['date_last_modif'];
                $chapters[] = $chapter;
            }
            return $chapters;
        } else {
            return null;
        }
    }

    /**
     * Method to retrieve the id of the first published chapter
     * 
     * @return int  the id of the chapter or null
     */
    public function getFirstPublishedChapterId(){
        $sql = "SELECT id FROM chapters WHERE id_state = 2 ORDER BY date_last_modif LIMIT 1";
        return $this->GetOne($sql);
    }
    /**
     * Method to retrieve the index of published chapters
     * 
     * @return array    This is an array containing an ID and a title
     * @throws Exception
     */
    public function getChapterList() {
        $sql = "SELECT id, title FROM chapters WHERE id_state = 2 ORDER BY id";
        $rows = $this->getAll($sql);
        if (!empty($rows)) {
            return $rows;
        } else {
            throw new Exception('Aucun chapitre créé...');
        }
    }
    
    /**
     * Retrieve the list of all chapters(except deleted one)
     * 
     * @param int $idState The state id of the chapters
     * @return array    this is an array of 'Chapitre' object
     *         null     if no chapters have been found
     */
    public function getAllChapters( $idState){
        if ($idState == 1) {
            $inner = 'id_state = 1';
        }elseif ($idState == 2) {
            $inner = 'id_state = 2';
        }else {
            $inner = 'id_state = 1 OR id_state = 2';
        }
        $sql = "SELECT id, title, id_state, date_last_modif FROM chapters "
                . "WHERE $inner ORDER BY id";
        $rows = $this->getAll($sql);
        if (!empty($rows)){
            $chapters = array();
            foreach ($rows as $row){
                $chapter = new Chapitre();
                $chapter->id = $row['id'];
                $chapter->title = $row['title'];
                $chapter->id_state = $row['id_state'];
                $chapter->date_last_modif = $row['date_last_modif'];
                $chapters[] = $chapter;
            }
            return $chapters;
        } else {
            return null;
        }        
    }
    
    /**
     * Method to calculate the number of differents type of
     * chapters in the DB
     * 
     * @return array    An array with the chapters counts
     */
    public function getTotalChapterDetail(){
        $chapters = array();
        $chapters['total'] = $this->getNumberChapter('all');
        $chapters['edit'] = $this->getNumberChapter('edit');
        $chapters['publish'] = $this->getNumberChapter('publish');
        return $chapters;
    }
    
    /**
     * Gets the total number of chapter
     * 
     * @return int  The number of chapter returned
     */
    public function getTotalChapter(){
        return $this->getNumberChapter('all');
    }


    /**
     * Method that counts the number of chapter for a given state
     * 
     * @param string $type  The type of chapters (all, edit or published)
     * @return int          The number of the chapters in this category
     */
    private function getNumberChapter( $type) {
        if ($type == 'edit') {
            $inner = 'id_state = 1';
        } elseif ($type == 'publish') {
            $inner = 'id_state = 2';
        } else {
            $inner = 'id_state = 1 OR id_state = 2';
        }
        $sql = "SELECT COUNT(*) FROM chapters WHERE " .$inner;
        return $this->GetOne($sql);
    }
    
    /**
     * Method to add a new chapter in the database
     * 
     * @param string $title     The title of the chapter
     * @param string $content   The content of the chapter
     * @param int $state        The state of the chapter
     * @param int $user         The user ID of the user who created the chapter
     */
    public function saveNewChapter( $title,  $content,  $state,  $user){
        $sql = "INSERT INTO chapters (title, content, id_user, id_state, date_last_modif)"
                . " VALUES (:title, :content, :id_user, :id_state, NOW())";
        $params = array(
            ':title' => $title,
            ':content' => $content,
            ':id_user' => $user,
            ':id_state' => $state
        );
        $this->execute($sql, $params);
    }
    
    /**
     * Method to update the state of a chapter
     * 
     * @param int $id       The ID of the chapter being updated
     * @param int $state    The state of the chapter
     */
    public function updateState( $id,  $state){
        $sql = "UPDATE chapters SET id_state = :id_state, date_last_modif = NOW() WHERE id = :id";
        $params = array(
            ':id_state' => $state,
            ':id' => $id
        );
        $this->execute($sql, $params);
    }

    /**
     * Method to update a chapter
     * 
     * @param int $id           The ID of the chapter
     * @param string $title     The title of a chapter
     * @param string $content   The content of the chapter
     * @param int $state        the state of the chapter
     */
    public function updateChapter( $id,  $title,  $content,  $state){
        $sql = "UPDATE chapters SET title = :title, content = :content, id_state = :state,"
                . " date_last_modif = NOW() WHERE id = :id";
        $params = array(
            ':id' => $id,
            ':title' => $title,
            ':content' => $content,
            ':state' => $state
        );
        $this->execute($sql, $params);
    }
}
