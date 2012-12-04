<?php
require_once('http.php');

define("QUERY_BRAIN_API_ROOT", "https://miogensearch/API/1");

class QueryBrain {
    
    var $apiKey;
    
    public function __construct ($apiKey) {
        $this->apiKey = $apiKey;
    }
    
    /**
     * Get the query database schema
     * @return array
     * @throws Exception
     */
    public function getSchema () {
        $response = HttpClient::callServer("GET", QUERY_BRAIN_API_ROOT . "/Databases/$this->apiKey/Schema");
        if ($response->getStatus() == 200) {
            return $response->getBody();
        }
        else {
            throw new Exception("Unable to get schema");
        }
    }
    
    /**
     * Sets the query database schema
     * @param array $schema
     * @return array
     * @throws Exception
     */
    public function setSchema ($schema) {
        $response = HttpClient::callServer("PUT", QUERY_BRAIN_API_ROOT . "/Databases/$this->apiKey/Schema", $schema);
        if ($response->getStatus() == 204) {
            return $response->getBody();
        }
        else {
            throw new Exception("Unable to set schema");
        }
    }
    
    /**
     * Adds or updates an item
     * @param array $item
     * @return boolean True if successful
     * @throws Exception
     */
    public function setItem ($item) {
        $response = HttpClient::callServer("POST", QUERY_BRAIN_API_ROOT . "/Databases/$this->apiKey/Items/", $item);
        if ($response->getStatus() == 201) {
            return true;
        }
        else {
            throw new Exception("Unable to set item");
        }
    }
    
    /**
     * Gets an item
     * @param String $id
     * @return array
     * @throws Exception
     */
    public function getItem ($id) {
        $response = HttpClient::callServer("GET", QUERY_BRAIN_API_ROOT . "/Databases/$this->apiKey/Items/$id");
        if ($response->getStatus() == 200) {
            return $response->getBody();
        }
        else {
            throw new Exception("Unable to get item");
        }
    }
    
    /**
     * Get all the items
     * @param Int $start The item index to start at (first is zero)
     * @param Int $limit The number of items to get
     */
    public function getItems ($start = 0, $limit = 50) {
        $response = HttpClient::callServer("GET", QUERY_BRAIN_API_ROOT . "/Databases/$this->apiKey/Items/?start=$start&limit=$limit");
        if ($response->getStatus() == 200) {
            return $response->getBody();
        }
        else {
            throw new Exception("Unable to get items");
        }
    }
    
    /**
     * Query the items
     * @param String $queryString The query string to search against
     * @param Int $start The item index to start at (first is zero)
     * @param Int $limit The number of items to get
     * @return array
     * @throws Exception
     */
    public function queryItems ($queryString, $start = 0, $limit = 50) {
        $response = HttpClient::callServer("GET", QUERY_BRAIN_API_ROOT . "/Databases/$this->apiKey/Items/?q=" . urlencode($queryString) . "&start=$start&limit=$limit");
        if ($response->getStatus() == 200) {
            return $response->getBody();
        }
        else {
            throw new Exception("Unable to query items");
        }
    }
}

?>