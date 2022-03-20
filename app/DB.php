<?php

namespace app;

use PDO;
use PDOException;

class DB
{
    /**
     * @return PDO
     */
    public static function conn(): PDO
    {
        try {
            $sth = new PDO(
                "mysql:host=" . $_ENV['DBHOST'] . // DATABASE HOST
                ";dbname=" . $_ENV['DBNAME'], //DATABASE NAME
                $_ENV['DBUSERNAME'], // DATABASE USERNAME
                $_ENV['DBPASSWORD'] // DATABASE PASSWORD
            );
            $sth->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $sth->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $sth;
    }

    public static function query($query, $params = [])
    {
        $smt = self::conn()->prepare($query);
        $smt->execute($params);
        return $smt;
    }
}