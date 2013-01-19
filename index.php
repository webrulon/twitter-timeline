<?php
    /*
     * load the baseapp bootstrap
     */

    require_once 'init/bootloader.php';
    
    $twitter->only_authed();
    
    $profile = $twitter->connect();
    
    $theme->elem('header');
    
    $theme->js_footer('front-page');
?>
<div class="page-header">
    <h2>Twitter Timeline</h2>
</div>

<div class="row-fluid">
    <div class="offset3 span6">
        <div><img src="<?php echo $profile->profile_image_url ?>">
        <div><?php echo $profile->name ?></div>
    </div>
</div>

<div class="row-fluid">
    <div class="span6 offset3">
        <?php // get tweets ?>
        <h3>Latest 10 Tweets</h3>
        <p><a target="_blank" href="<?php echo ABSPATH . DS . 'pdf.php' ?>" class="btn btn-primary">Download as pdf</a></p>
            
        <?php
            //for carousel
            $tweet = $twitter->get_tweet(10);
        ?>
        <div id="user-tweet">
            <div class="carousel-inner">
                <?php foreach( $tweet as $t ): ?>
                    <div class="item"><p><?php echo $t->text ?></p></div>
                <?php endforeach; ?>
            </div>
            <a class="carousel-control left" href="#user-tweet" data-slide="prev">&lsaquo;</a>
            <a class="carousel-control right" href="#user-tweet" data-slide="next">&rsaquo;</a>
        </div>
        
        <hr/>
        
        <?php // get followers ?>
        <h3>10 Random Followers</h3>
        <?php
            
            $follower_obj = $twitter->get_follower('all');
            var_dump($follower_obj);
            
            $follower = $twitter->userobj_To_sn_fn( $follower_obj );
            //printing form for taking input
        ?>
        <form class="form-horizontal">
            <div id="responce_err" class="alert-error hide">Oops, There is a problem, try later</div>
            <label>Load Tweet</label>
            <input name="_user" id="_user" data-provide="typeahead" data-source='<?php echo json_encode($follower) ?>' >
        </form>
        
        <ol>
        <?php
        
            //get random follower
            //how many followers does the visitor have
            $rand = array();
            $select_min = min( count($follower) , 10);
            
            if( $select_min > 0 )
                $rand = array_rand($follower,
                        //dont ask more tweet that catually their are
                        $select_min
                );
            
            //printing the list of random user
            if( $select_min > 0 ){
                
                foreach($rand as $i){
                    printf("<li>%s</li>", $follower[$i]);
                }
            }
        ?>
        </ol>
    </div>
</div>
<?php $theme->elem('footer'); ?>