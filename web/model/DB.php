<?php

class DB
{
    public mysqli $conn;

    public function __construct()
    {
        $data = json_decode(file_get_contents(ROOT.'/config/db.json'), 1)['MySQL'];
        $this->conn = new mysqli($data['host'], $data['user'], $data['password'], $data['db']);

        if($this->conn->connect_error)
        {
            throw new Exception('Unable to connect with database');
        }
    }

    public function __destruct()
    {
        $this->conn->close();
    }

}