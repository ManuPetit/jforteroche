<?php

require_once 'Configuration.php';

/**
 *          Access to the database Class
 */
abstract class Model {

    //  PDO Object
    private static $db;

    /**
     * Get the PDO object and initialise the connection
     * @return PDO objet connection to the DB
     */
    private function getDB() {
        if (self::$db === null) {
            //on récupère les paramètres configuration de la base
            $dsn = Configuration::getSetting("dsn");
            $login = Configuration::getSetting("login");
            $mdp = Configuration::getSetting("mdp");
            //création de la connexion
            try {
                self::$db = new PDO($dsn, $login, $mdp, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            } catch (PDOException $ex) {
                self::close();
                throw new Exception($ex);
            }
        }
        return self::$db;
    }

    /**
     *  End of PDO connection
     */
    protected function close() {
        self::$db = NULL;
    }

    /**
     * Execute a query or stored procedure
     * @param string $sql   SQL query
     * @param array $params Parameters of the query
     */
    protected function execute($query, $params = null) {
        try {
            $handler = self::getDB();
            $statement = $handler->prepare($query);
            return $statement->execute($params);
        } catch (PDOException $ex) {
            throw new Exception($ex);
        }
    }

    /**
     * Permet l'éxécution d'une requête ou d'une procédure stockée pour retrouver une liste 
     * d'élément
     * @param string $query : la requête
     * @param array $params : les paramètres de la requête
     * @return array : un tableau contenant le result de la requête
     */
    protected function getAll($query, $params = null) {
        $result = null;
        try {
            $handler = self::getDB();
            $statement = $handler->prepare($query);
            if (isset($params[0]['name']) && $params[0]['name'] != '') {
                foreach ($params as $param) {
                    $statement->bindParam($param['name'], $param['value'], $param['type']);
                }
                $statement->execute();
            } else {
                $statement->execute($params);
            }
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $ex) {
            throw new Exception($ex);
        }
        return $result;
    }

    /**
     * Permet l'éxécution d'une requête ou d'une procédure stockée pour retrouver un élément
     * @param string $query : la requête
     * @param array $params : les paramètres de la requête
     * @return array : un tableau contenant le result de la requête
     */
    protected function getRow($query, $params = null) {
        $result = null;
        try {
            $handler = self::getDB();
            $statement = $handler->prepare($query);
            $statement->execute($params);
            $result = $statement->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $ex) {
            throw new Exception($ex);
        }
        return $result;
    }

    /**
     * Permet l'éxécution d'une requête ou d'une procédure stockée pour retrouver une unique valeur
     * @param string $query : la requête
     * @param array $params : les paramètres de la requête
     * @return array : un tableau contenant le result de la requête
     */
    protected function GetOne($query, $params = NULL) {
        $result = NULL;
        try {
            $handler = self::getDB();
            $statement = $handler->prepare($query);
            $statement->execute($params);
            $result = $statement->fetch(PDO::FETCH_NUM);
            //Get the first value
            $result = $result[0];
        } catch (PDOException $ex) {
            throw new Exception($ex);
        }
        //retourne le resultat
        return $result;
    }

}
