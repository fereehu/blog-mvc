<?php

class Controller {

    public $db = null;

    function __construct() {
        $this->openDatabaseConnection();   //nyisson egy DB kapcsolatot. 
        try {
            $db = $this->db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    private function openDatabaseConnection() {
        $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);
        $this->db = new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS, $options);
    }

    public function loadModel($model_name) { //a modelleket betölti. 
        require './application/models/' . strtolower($model_name) . '.php';
        return new $model_name($this->db);
    }

}
