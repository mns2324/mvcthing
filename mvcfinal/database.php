<?php

class Database
{
    private $connection;

    public function __construct()
    {
        // get the database credentials from the config file
        $config = require __DIR__ . '/config.php';

        // set the db connection here so that you don't have to call this every time you want to query
        $this->connection = new mysqli(
            $config['HOST'],
            $config['USER'],
            $config['PASSWORD'],
            $config['DATABASE'],
            3307
        );

        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }
}