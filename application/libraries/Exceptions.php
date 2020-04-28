<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exceptions {

    public function checkForError() {
        get_instance()->load->database();
        $error = get_instance()->db->error();
        if ($error['code'])
            throw new MySQLException($error);
    }
}

abstract class IMySQLException extends Exception {
    public abstract function getErrorMessage();
}

class MySQLException extends IMySQLException {
    private $errorNumber;
    public $errorMessage;

    public function __construct(array $error) {
        
        $this->errorNumber = "Error Code(" . $error['code'] . ")";
        $this->errorMessage = $error['message'];
    }

    public function getErrorMessage() {
        return array(
            "error" => array (
                "code" => $this->errorNumber,
                "message" => $this->errorMessage
            )
        );
    }

}