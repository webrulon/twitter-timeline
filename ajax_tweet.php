<?php
    /*
     * load the baseapp bootstrap
     */

    require_once 'init/bootloader.php';
    
    header('Content-type: application/json');
    
    $twitter->only_authed();
    
    if( empty($_REQUEST['screen_name']) ){
        
        //dont waste resource
        ?>{error: "screen_name empty"}<?php
        exit();
    }
    
    $twitter->connect();
    
    //take precaution for getting input from outside world
    $screen_name = (string)$_REQUEST['screen_name'];
    
    
    //NOTE: tweets may not load because , the app is not authz to get data
    //      it happen in some cases
    
    $tweet = $twitter->get_tweet(10, $screen_name );
    
    if( isset( $tweet->error ) ){
        
        //we received an error, pass it to client
        echo json_encode($tweet);
        exit();
    }
    
    //only send what asked, every bit matters
    $tweet_send = array();
    
    foreach( $tweet as $t){
        $tweet_send[] = $t->text;
    }
    
    echo json_encode($tweet_send);