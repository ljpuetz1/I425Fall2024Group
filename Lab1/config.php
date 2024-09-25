<?php
/**
 * Author: Logan Puetz
 * Date: 9/25/2024
 * File: config.php
 * Description: Config file to connect to the blog database
 */

$db = [
    'host' => 'localhost',
    //reuse the blog db for this assignment
    'database' => 'blog',
    'username' => 'phpuser',
    'password' => 'phpuser',
    'port' => 3306
];
return $db;