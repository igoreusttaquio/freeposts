<?php

abstract class Connection
{
    private static $conn;

    static function getConnection()
    {
        if(self::$conn == null)
        {
            self::$conn = new PDO('sqlite:Infra/postagens.db');
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        
        return self::$conn;
    }
}