<?php
/**
 * Author: Logan Puetz, Ryan cook, Nathan ensley
 * Date: 9/25/2024
 * File: DB.php
 * Description:
 */
class DB
{
    function connect($db)
    {
        $conn = new mysqli($db['host'], $db['username'], $db['password'],
            $db['database'], $db['port']);
        if ($conn->connect_error) {
            die('Connect Error (' . $conn->connect_errno . ') '
                . $conn->connect_error);
        }
        return $conn;
    }
}