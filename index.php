<?php
    /*
     * load the baseapp bootstrap
     */

    require_once 'init/bootloader.php';
    
    if( $twitter->is() ){
        //is the user authz
        header('location: ' . TWITTER_LANDPAGE);
        exit();
    }

    $theme->elem('header');
    $theme->elem('hero-unit');
    $theme->elem('footer');
?>