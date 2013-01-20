<?php

include_once _LIB . DS . 'twitteroauth/twitteroauth.php';


/* a small hack */
class TwitterOAuth1dot1 extends TwitterOAuth{
    
    /* modifiying for twitter new api 1.1 */
    public $host = TWITTER_API_URL;
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
     * 
     * 
     * 
     * @return users object
     */
    
    function get_follower($count = 'all' , $screen_name = NULL){
        
        /*
         * load all followers id
         * it is better than loading single 20 list using followers/list
         */
        
        $followers_id = $this->followers_id( $count, $screen_name );
        
        return $this->user_lookup($followers_id);
    }
    
    /*
     * do a user/users lookup
     * 
     * @param id array or single id of user to lookup, ( array(ids) or id or screen_name )
     * 
     * @return
     *  single id or screen_name: user object
     *  array ids: user object collection
     */
    
    function user_lookup( $id, $include_entities = false ){
    
        if( is_array( $id ) ){
            //vola, an array of id's
            //
            //do lookup for all id's
            $id_chunk = array_chunk( $id, TWITTER_MAX_USER_LOOKUP );
            
            $lookup = array();
            
            foreach( $id_chunk as $id_c ){

                $data = $this->conn->get('users/lookup', array(
                    'user_id' => implode( ',', $id_c ),
                    'include_entities' => $include_entities
                ) );

                $lookup = array_merge( (array)$lookup, (array)$data);
            }
            
            return $lookup;
            
        } else {
            
            $var = array( 'include_entities' => $include_entities );
            
            if( is_int($id) ){
                
                //assuming it as user_id
                $var['user_id'] = $id;
                
            } else {
                
                //assuming it as screen_name
                $var['screen_name'] = $id;
                
            }
            
            //assuming it as single id
            $data = $this->conn->get('users/lookup', $var );
            
            return $data[0];
        }
    }
    
    /*
     * get the array of follower id of a specific user
     * 
     * @param count : max number of followers id to return
     * @param screen_name: name of the user whose followers id to fetch
     * 
     * @return array of id's
     */
    
    function followers_id( $count = 'all', $screen_name = NULL ){
        
        if( $screen_name == NULL ){
            $screen_name = $this->user->screen_name;
        }
        
        $followers_id = array();
        $cursor = '-1';
        $i = 0;
        
        $i_max = 0;
        if( $count != 'all' )
            $i_max = ceil( $count / TWITTER_MAX_ID_FETCHED );
        
        //if followers count exceed max fetcable id's then download them in partitions
        while( true ){

            $request = $this->conn->get('followers/ids', compact('screen_name','cursor') );
            
            //dont get any id's useless to do more request
            if( ! count($request->ids) ){
                break;
            }
            
            //got that much tweets , that we wanted
            if( $count != 'all' AND $i >= $i_max ){
                break;
            }
            
            $followers_id = array_merge( (array)$followers_id, (array)$request->ids );
            
            $cursor = $request->next_cursor;
            $i++;
        }
        
        /*
         * how many followers we need
         */
        if( $count != 'all' AND $count > count( $followers_id ) ){
            
            //select some random followers
            $followers_id = array_rand($followers_id, $count);
            
        }
        
        return $followers_id;
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