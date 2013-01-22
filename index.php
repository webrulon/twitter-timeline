<?php
    /*
     * the main page ,here visitor can see all the required things
     */

     // load the baseapp bootstrap
    require_once 'init/bootloader.php';
    
    $twitter->only_authed();

    $theme->elem('header');
    
    $theme->js_footer('front-page');
    
?>
        <div class="row-fluid">
            <div class="span6">
                <?php // get tweets ?>
                <h3>Latest 10 Tweets <a id="download-pdf" href="<?php echo ABSPATH . DS . 'pdf.php' ?>?screen_name=<?php echo $twitter->user->screen_name ?>" class="label label-info">Download as PDF</a></h3>            
                <?php
                    //for carousel
                    $tweet_raw = $twitter->get_tweet(10);
                    
                    $tweets = array();
                    
                    foreach( $tweet_raw as $t ){
                        $tweets[] = $t->text;
                    }
                    
                    $tweets = beautify_tweets( $tweets );
                    
                ?>
                <div id="user-tweet">
                    <div class="carousel-inner">
                        <?php foreach( $tweet as $t ): ?>
                            <p class="item"><?php echo $t ?></p>
                        <?php endforeach; ?>
                    </div>
                    <a class="carousel-control left" href="#user-tweet" data-slide="prev">&lsaquo;</a>
                    <a class="carousel-control right" href="#user-tweet" data-slide="next">&rsaquo;</a>
                </div>
            </div>
            
            <?php // get followers ?>
            <div class="span6">
                <h3>10 Random Followers</h3>
                <?php

                    $follower = $twitter->get_follower('all');

                    //extract all screen_name
                    $screen_names = array();
                    foreach($follower as $f){
                        $screen_names[] = $f->screen_name;
                    }
                    //printing form for taking input
                ?>
                <div class="form-horizontal">
                    <div id="ajax-responce">
                        <div class="alert alert-error hide">
                            Oops, There is a problem, try later
                            <a class="close" data-dismiss="alert" href="#">&times;</a>
                        </div>
                        <div class="alert alert-info hide">
                            Please Wait, Loading Tweets...
                            <a class="close" data-dismiss="alert" href="#">&times;</a>
                        </div>
                    </div>

                    <div class="control-group">
                        <label>Load Tweet</label>
                        <div class="input-prepend">
                            <span class="add-on">@</span>
                            <input type="text" id="screen-name" data-source='<?php echo json_encode($screen_names) ?>' >
                        </div>
                    </div>
                </div>

                <?php

                    //get random follower
                    //how many followers does the visitor have
                    $rand = array();
                    $select_min = min( count($follower) , 10);

                    //printing the list of random user
                    if( $select_min > 0 ):

                        $rand = array_rand($follower,
                                //dont ask more tweet that catually their are
                                $select_min
                        );

                        echo '<ol>';

                        foreach($rand as $id){
                            printf('<li><a target="_blank" class="twitter-user" href="https://twitter.com/%1$s">@%1$s</a> %2$s</li>',
                                    $follower[$id]->screen_name, $follower[$id]->name
                                );
                        }

                        echo '</ol>';

                    else:
                        ?><p class="alert-info">pretty bad , no follower till now</p><?php
                    endif;
                ?>
            </div>
        </div>
<?php $theme->elem('footer'); ?>