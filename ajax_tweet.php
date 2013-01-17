<?php
    /*
     * load the baseapp bootstrap
     */

    require_once 'init/bootloader.php';
    
    $twitter->only_authed();
    
    if( empty($_REQUEST['username']) ){
        
        //dont waste resource
        ?>{error: "username empty"}<?php
        exit();
    }
    
    $twitter->connect();
    
    //take precaution for getting input from outside world
    $username = strval($_REQUEST['username']);
    
    $tweet = $twitter->get_tweet(10, $username );

    //only send what asked, every bit matters
    $tweet_send = array();
    
    foreach( $tweet as $t){
        $tweet_send[] = $t->text;
    }
    
    json_encode($tweet_send);