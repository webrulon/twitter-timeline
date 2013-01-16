<?php

include_once _LIB . 'twitteroauth.php';

class Twitter{
    
    private $conn = NULL;
    private $tmp = NULL;
    
    function __construct($key, $secret) {
        
        if( $this->is() ){
            
            
            $this->conn = new TwitterOAuth(
                $key,
                $secret,
                $_SESSION['oauth_token'],
                $_SESSION['oauth_token_secret']
            );
            
        }
        else {
            
            $this->conn = new TwitterOAuth($key, $secret);
            $this->tmp = $this->conn->getRequestToken(TWITTER_LANDPAGE);
        }
        
    }
    
    /*
     * is the user login'ed
     */
    
    function is(){
        
        return isset( $_SESSION['oauth_token'] );
    }
    
    /*
     * get url for login
     */
    
    function url(){
        
        return $connection->getAuthorizeURL($this->tmp, FALSE);
    }
    /*
     * get the lastest n tweets
     * @param num number of tweets
     */
    function get($num){
        
    }
}

$twitter = new Twitter(TWITTER_KEY, TWITTER_SECRET);