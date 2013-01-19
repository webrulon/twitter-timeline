<?php

include_once _LIB . DS . 'twitteroauth/twitteroauth.php';


/* a small hack */
class TwitterOAuth1dot1 extends TwitterOAuth{
    
    /* modifiying for twitter new api 1.1 */
    public $host = "https://api.twitter.com/1.1/";
}

class Twitter{
    
    private $conn = NULL;
    
    private $user = NULL;
    
    /*
     * is the user login'ed
     */
    
    function is_unauthed(){
        
        return (empty($_SESSION['access_token']) || empty($_SESSION['access_token']['oauth_token']) || empty($_SESSION['access_token']['oauth_token_secret']));
    }
    
    /*
     * only allow authed users
     */
    function only_authed(){
        if( $this->is_unauthed() ){
            $this->clear();
        }
    }
    /*
     * get URI for login
     */
    
    function login_url(){
        
        $connection = new TwitterOAuth1dot1(TWITTER_KEY, TWITTER_SECRET);
        $request_token = $connection->getRequestToken(TWITTER_CALLBACK);

        /* Save temporary credentials to session. */
        $_SESSION['request_token'] = $request_token;
        $token = $request_token['oauth_token'];
        
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
        $this->conn = new TwitterOAuth1dot1(TWITTER_KEY, TWITTER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);

        /* If method is set change API call made. Test is called by default. */
        $content = $this->conn->get('account/verify_credentials');
        
        if( $this->conn->http_code != 200 ){
            
            //unable to verify, so clear the user session, and re-request auth'z
            $this->clear();
        }
        
        //save for others
        $this->user = $content;
        
        return $content;
    }
    
    /*
     * get the lastest n tweets
     * 
     * @param count number of tweets
     * @param screen_name name of the user whose tweets to fetch, (option)
     */
    function get_tweet($count, $screen_name = NULL){
        
        if( $screen_name == NULL ){
            $screen_name = $this->user->screen_name;
        }
        return $this->conn->get('statuses/user_timeline', compact('count','screen_name'));
        
    }
    
    /*
     * get followers
     * 
     * @param count maximum number of followers to fetch (optional)(default "all")
     * @param screen_name screen-name of user whose follower to fetch(optional)
     */
    
    function get_follower($count = 'all' , $screen_name = NULL){
        
        var_dump($_SESSION);
        
        if( $count == 'all' ){
            $count = $this->user->followers_count;
        }
        
        if( $screen_name == NULL ){
            $screen_name = $this->user->screen_name;
        }
        
        $list = array();
        $i = 0;
        $cursor = '0';
        $response = NULL;
        
        $skip_status = true;
        
        while( $i < $count ){
            
            $response = $this->conn->get('followers/list', compact('cursor', 'screen_name','skip_status'));
            
            var_dump($response);
            
            if( ! count($response->users) ){
                
                //we have nothing to save now
                break;
            }
            
            $cursor = $response->next_cursor_str;
            
            foreach( $response->users as $u ){
                
                if( $i < $count )
                    $list[] = $u;
                else
                    break;
                
                $i++;
            }
        }
        
        return $list;
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
        $connection = new TwitterOAuth1dot1(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['request_token']['oauth_token'], $_SESSION['request_token']['oauth_token_secret']);

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