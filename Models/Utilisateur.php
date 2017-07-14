<?php

require_once 'App/Model.php';

/**
 *      Class representing a Utilisateur object
 */
class Utilisateur extends Model {

    //          private properties of the 'Utilisateur' model
    private $id;
    private $login;
    private $email;
    private $name;
    private $surname;
    private $password;
    private $salt;  //internal use. never shown. no getter or setter
    private $date_last_login;

    //          Getters and setters
    //  read only property
    public function getId(){
        return $this->id;
    }
    
    public function getLogin() {
        return $this->login;
    }
    
    public function setLogin(string $login) {
        $this->login = $login;
    }
    
    public function getEmail(){
        return $this->email;
    }
    
    public function setEmail(string $email){
        $this->email = $email;
    }
    
    public function getName(){
        return $this->name;
    }
    
    public function setName(string $name){
        $this->name = $name;                
    }
    
    public function getSurname(){
        return $this->surname;
    }
    
    public function setSurname(string $surname){
        $this->surname = $surname;
    }
    
    //  read only property
    public function getFullName(){
        return ucfirst($this->name) . ' ' . ucfirst($this->surname);
    }
    
    //  This is the hashed password as it is in the DB
    public function getPassword() {
        return $this->password;
    }    
    
    //  read only property
    //  The output date is formatted to french system
    public function getDateLastLogin(){
        $date = date_create($this->date_last_login);
        return date_format($date, 'd/m/Y à H:i');
    }
    
    //          Methods
    /**
     * This setters takes a password entered by the user.
     * It check to see if a salt exist (if not, it creates it)
     * It then creates the hashed password
     * 
     * @param string $password  The password typed by the user.
     */
    public function setPassword(string $password){
        if (isset($this->salt) && $this->salt != '') {
            $this->password = $this->makePassword($password, $this->salt);
        } else {
            $this->salt = $this->generateSalt();
            $this->password = $this->makePassword($password, $this->salt);
        }
    }
    
    /**
     * Check if a user can login with a given password
     * 
     * @param string $name      The login name of the user
     * @param string $password  The password of the user
     * @return boolean          True if we have a match otherwise false
     */
    public function canLogin(string $name, string $password) {
        //get the salt for this user
        $salt = $this->getUserSalt($name);
        if (isset($salt) && ($salt != '')) {
            $hash = $this->makePassword($password, $salt);
            //check pseudo against hash
            $sql = "SELECT id, email FROM users WHERE login = :name AND password = :hash";
            $params = array(
                ':name' => $name,
                ':hash' => $hash
            );
            $login = $this->getRow($sql, $params);
            if (isset($login) && $login != '') {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * This get all the details from a user. They are stored
     * in the revelant properties
     * 
     * @param string $name
     * @param string $password
     * @throws Exception
     */
    public function getUserDetails(string $name, string $password) {
        $salt = $this->getUserSalt($name);
        $hash = $this->makePassword($password, $salt);
        $sql = "SELECT id, login, email, name, surname, date_last_login "
                . "FROM users WHERE login = :name AND password = :hash";
        $params = array(
            ':name' => $name,
            ':hash' => $hash
        );
        $row = $this->getRow($sql, $params);
        if (!empty($row)) {
            $this->id = $row['id'];
            $this->login = $row['login'];
            $this->email = $row['email'];
            $this->name = $row['name'];
            $this->surname = $row['surname'];
            $this->password = $hash;
            $this->salt = $salt;
            $this->date_last_login = $row['date_last_login'];
        } else {
            throw new Exception("Erreur de données");
        }
    }

    public function getUser(int $idUser){
        $sql = "SELECT login, email, name, surname , password, salt, date_last_login "
                . "FROM users WHERE id = :id";
        $params = array(':id' => $idUser);
        $row = $this->getRow($sql, $params);
        if (!empty($row)) {
            $this->id = $idUser;
            $this->login = $row['login'];
            $this->email = $row['email'];
            $this->name = $row['name'];
            $this->surname = $row['surname'];
            $this->password = $row['password'];
            $this->salt = $row['salt'];
            $this->date_last_login = $row['date_last_login'];
        } else {
            throw new Exception('Utilisateur inconnu');
        }
    }
    /**
     * Update the login time of a user
     * 
     * @param int $idUser
     */
    public function updateLastLogin(int $idUser){
        $sql = "UPDATE users SET date_last_login = NOW()"
                . " WHERE id = :idUser";
        $params = array(':idUser' => $idUser);
        $this->execute($sql, $params);
    }
    
    /**
     * gets the user salt to generate a password
     * 
     * @param string $name  The login name of the user
     * @return string       The salt
     */
    private function getUserSalt(string $name) {
        $sql = "SELECT salt FROM users WHERE login = :name";
        $params = array(':name' => $name);
        $salt = $this->GetOne($sql, $params);
        return $salt;
    }

    /**
     * generate a new salt when creating a user
     * 
     * @param int $max  Maximum number of characters in the salt
     * @return string   The salt generated
     */
    private function generateSalt(int $max = 64) {
        $characterList = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*?";
        $i = 0;
        $salt = "";
        while ($i < $max) {
            $salt .= $characterList{mt_rand(0, (strlen($characterList) - 1))};
            $i++;
        }
        return $salt;
    }

    /**
     * 
     * @param string $password  The password of the user
     * @param string $salt      The salt of the user
     * @return string           The hashed password to be stocked in the DB
     */
    private function makePassword(string $password, string $salt) {
        $combo = $salt . $password;
        $hash = hash('sha512', $combo);
        return $hash;
    }

}
