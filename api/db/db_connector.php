<?php

class DatabaseConnector  {

    private $accountConnection = null;
    private $shopConnection = null;

    public function __construct()
    {
        // try {
        //     $this->accountConnection = new SQLite3('./accounts.db');
        //     $this->shopConnection = new SQLite3('./shop.db');
        // } catch (Exception $e) {
        //     echo 'Database exception: ' . $e->getMessage();
        //     exit($e->getMessage());
        // }
    }

    public function getAccountDbConnection()
    {

        try {
            $this->accountConnection = new \PDO("sqlite:" ."../db/accounts.db");
            return $this->accountConnection;
        } catch (\PDOException $e) {
            echo 'Database exception: ' . $e->getMessage();
            exit($e->getMessage());
        }
    }

    public function getShopDbConnection()
    {
        try {
            $this->shopConnection = new \PDO("sqlite:" ."../db/shop.db");
            return $this->shopConnection;
        } catch (\PDOException $e) {
            echo 'Database exception: ' . $e->getMessage();
            exit($e->getMessage());
        }
    }
}