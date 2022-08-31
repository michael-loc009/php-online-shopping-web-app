<?php

class DatabaseConnector extends SQLite3  {

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
            $this->accountConnection = $this->open("./accounts.db");

            return $this->accountConnection;
        } catch (Exception $e) {
            echo 'Database exception: ' . $e->getMessage();
            exit($e->getMessage());
        }
    }

    public function getShopDbConnection()
    {
        try {
            $this->shopConnection = $this->open("./db/shop.db");
            return $this->shopConnection;
        } catch (Exception $e) {
            echo 'Database exception: ' . $e->getMessage();
            exit($e->getMessage());
        }
    }
}