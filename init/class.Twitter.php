<?php

include_once _LIB . DS . 'twitteroauth/twitteroauth.php';

class Twitter{
    
    private $conn = NULL;
    
    /*
     * is the user login'ed
     */
    
    function is(){
        
        return (empty($_SESSION['access_token']) || empty($_SESSION['access_token']['oauth_token']) || empty($_SESSION['access_token']['oauth_token_secret']));
    }
    
    /*
     * get URI for login
     */
    
    function login_url(){
        
        $connection = new TwitterOAuth(TWITTER_KEY, TWITTER_SECRET);
        $request_token = $connection->getRequestToken(TWITTER_CALLBACK);

        /* Save temporary credentials to session. */
        $_SESSION['request_token']['oauth_token'] = $token = $request_token['oauth_token'];
        $_SESSION['request_token']['oauth_token_secret'] = $request_token['oauth_token_secret'];
        
        return $connection->getAuthorizeURL($token, FALSE);
    }
    
    /*
     * connect to twitter and store the connection for later use
     * only used by access_token / retreving after verified
     * 
     * if verified, return the profile
     */
    
    function connect(){
        
        /* Get user access tokens out of the session. */
        $access_token = $_SESSION['access_token'];

        /* Create a TwitterOauth object with consumer/user tokens. */
        $this->conn = new TwitterOAuth(TWITTER_KEY, TWITTER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);

        /* If method is set change API call made. Test is called by default. */
        $content = $this->conn->get('account/verify_credentials');
        
        if( $this->conn->http_code != 200 ){
            
            //unable to verify, so clear the user session, and re-request auth'z
            $this->clear();
        }
        
        return $content;
    }
    
    /*
     * get the lastest n tweets
     * @param num number of tweets
     */
    function get_tweet($num){
        
    }
    
    /*
     * clear the session
     */
    
    function clear(){
        session_destroy();
        header('location: '. TWITTER_LOGIN );
        exit();
    }
    
    
    
    function callback(){
        /* If the oauth_token is old redirect to the connect page. */
        if (isset($_REQUEST['oauth_token']) && $_SESSION['request_token']['oauth_token'] !== $_REQUEST['oauth_token']) {
          
            //old token
            $this->clear();
        }
        
        /* Create TwitteroAuth object with app key/secret and token key/secret from default phase */
        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['request_token']['oauth_token'], $_SESSION['request_token']['oauth_token_secret']);

        /* Request access tokens from twitter */
        $access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);

        /* Save the access tokens. Normally these would be saved in a database for future use. */
        $_SESSION['access_token'] = $access_token;
        
        /* remove the request_token, no use */
        unset($_SESSION['request_token']);
        
        if (200 == $connection->http_code){
            
            header('location: ' . TWITTER_LANDPAGE);
            exit();
            
        } else{
            
            $this->clear();
        }
    }
}

$twitter = new Twitter(TWITTER_KEY, TWITTER_SECRET);