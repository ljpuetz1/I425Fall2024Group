<?php
/**
 * Author: Logan Puetz, Ryan Cook, Nathan Ensley
 * Date: 9/25/2024
 * File: Router.php
 * Description:
 */
class Router
{
    private $routes = [];
    function setRoutes($routes)
    {
        $this->routes = $routes;
    }
    function getFilename($url)
    {
        foreach ($this->routes as $route => $file) {
            if (strpos($url, $route) !== false) {
                return $file;
            }
        }
    }
}