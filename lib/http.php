<?php

class HttpClient {

    /**
     * Call a HTTP server
     * @param String $method The HTTP method to use
     * @param String $url The URL
     * @param Object $postData Optional object to encode as JSON to send as the message body
     * @return HttpResponse
     * @throws Exception
     */
    public static function callServer ($method, $url, $postData = null) {
        $ctx = stream_context_create(array(
            'http' => array(
                'method' => $method,
                'ignore_errors' => true,
                'follow_location' => 0,
                'content' => (is_null($postData) ? null : json_encode($postData))
            )
        ));

        $fp = @fopen($url, 'rb', false, $ctx);
        if (!$fp) {
            throw new Exception("Error connecting to server");
        }

        // Read the metadata
        $meta = stream_get_meta_data($fp);

        // Parse the response headers
        $headers = array();
        foreach ($meta['wrapper_data'] as $header) {
            if (strpos($header, 'HTTP/1.1') === 0) {
                $status = intval(substr(array_shift($meta['wrapper_data']), 9, 3));
            }
            else {
                list($key, $value) = explode(': ', $header, 2);
                $headers[$key] = $value;
            }
        }

        // Get the response content
        $responseText = @stream_get_contents($fp);
        if ($responseText === false) {
            throw new Exception("Error getting response"); 
        }

        // Parse the response
        $responseBody = null;
        if ($responseText != '') {
            $responseBody = json_decode($responseText, true);
        }

        // Return the result
        return new HttpResponse($status, $headers, $responseBody);
    }
}

class HttpResponse {
    var $status;
    var $headers;
    var $body;
    
    public function __construct($status, $headers, $body = null) {
        $this->status = $status;
        $this->headers = $headers;
        $this->body = $body;
    }
    
    public function getStatus () {
        return $this->status;
    }
    
    public function getHeaders () {
        return $this->headers;
    }
    
    public function getHeader ($header, $default = null) {
        return isset($this->headers[$header]) ? $this->headers[$header] : $default;
    }
    
    public function getBody () {
        return $this->body;
    }
}

?>