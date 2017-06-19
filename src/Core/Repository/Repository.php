<?php

/**
 * Created by PhpStorm.
 * User: birthright
 * Date: 10.05.17
 * Time: 21:21
 */
namespace Birthright\Core\Repository;
use PDO;
use PDOException;

abstract class Repository
{
    protected $DBH;

    function openConnection() :PDO{
        try {
            $this->DBH = new PDO("pgsql:host=localhost;port=5432;dbname=php;user=postgres;password=postgres");
            return $this->DBH;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return null;
    }
    function closeConnection(){
        $this->DBH = null;
    }
}