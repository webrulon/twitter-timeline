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
            <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
            <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
        </div>
        
        <hr/>
        
        <?php // get followers ?>
        <h3>10 Random Followers</h3>
        <?php
            $follower = $twitter->get_follower('all');
            $rand = array();
            $count = count($follower);
            $rnum ;//random number
            
            //get 10 random followers
            for($i = 0; $i < 10; $i++){
                
               //count-1 becuase its exclsive, and could cause overflow
               $rnum = rand(0, $count - 1);
               $rand = $follower[$rnum];
            }
            
            //data for json decode
            $forjson = array();
            foreach( $follower as $f ){
                $forjson[$f->username] = $f->name;
            }
        ?>
        <form class="form-horizontal">
            <div id="responce_err" class="alert-error">Oops, There is a problem, try later</div>
            <input name="_user" id="_user" data-provide="typehead" data-source="<?php echo json_decode($forjson) ?>">
        </div>
        <ol>
            <?php foreach($follower as $f): ?>
            <li><?php echo $f->name ?></li>
            <?php endforeach; ?>
        </ol>
    </div>
</div>
<?php $theme->elem('footer'); ?>