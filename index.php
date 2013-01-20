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
            
            $follower = $twitter->get_follower('all');
            
            //extract all screen_name
            $screen_names = array();
            foreach($follower as $f){
                $screen_names[] = strtolower($f->screen_name);
            }
            //printing form for taking input
        ?>
        <div class="form-horizontal">
            <div id="ajax_responce">
                <div class="alert-error hide">Oops, There is a problem, try later</div>
                <div class="alert-info hide">Please Wait, Loading Tweets...</div>
            </div>
            
            <div class='control-group'>
                <label>Load Tweet</label>
                <div class="input-prepend">
                    <span class="add-on">@</span>
                    <input type="text" name="screen_name" id="screen_name" data-provide="typeahead" data-source='<?php echo json_encode($screen_names) ?>' >
                </div>
            </div>
            
        </div>
        
        <?php
        
            //get random follower
            //how many followers does the visitor have
            $rand = array();
            $select_min = min( count($follower) , 10);
            
            //printing the list of random user
            if( $select_min > 0 ){
                
                $rand = array_rand($follower,
                        //dont ask more tweet that catually their are
                        $select_min
                );
                
                echo '<ol>';
                
                foreach($rand as $id){
                    echo '<li>@' . $follower[$id]->screen_name . ': ' . $follower[$id]->name . '</li>';    
                }
                
                echo '</ol>';
                
            } else {
                
                echo '<p class="alert-info">pretty bad , no follower till now</p>';
            }
        ?>
    </div>
</div>
<?php $theme->elem('footer'); ?>