<?php


class Database
{

        private $serverName = 'BANGALY\SQLEXPRESS';
        private $database = 'Nom_HotelDB';

        private $username = '';
        private $password = '';


        public function getConnection()
        {
                try {

                        $dsn = "sqlsrv:Server={$this->serverName};Database={$this->database}";

                        if ($this->username == null) {
                                $conn = new PDO($dsn);
                        } else {
                                $conn = new PDO($dsn, $this->username, $this->password);
                        }

                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                        // die('connecte avec succes');
                        return $conn;
                } catch (\Throwable $th) {
                        die($th->getMessage());
                }
        }
}
