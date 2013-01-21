<?php
    /*
     * im using twitter bootstrap
     * learn more about it on http://twitter.github.com/bootstrap/
     */
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Twitter Timeline</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Assignment For Baseapp For the post of web developer">
    <meta name="author" content="Kuldeep Singh Dhaka">
    
    <!-- This Website is responsive, check it yourself -->
    <!-- Tip:use Mozilla Firefox Responsive Design Tester -->
    
    <!-- Le styles -->
    <?php
        $theme->css('bootstrap/css/bootstrap', WEBROOT_LIB );
        $theme->css('bootstrap/css/bootstrap-responsive.min', WEBROOT_LIB );
        $theme->css('baseapp' );
    ?>
    
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>

  <body>
      <div id="header">
          <div class="navbar navbar-inverse navbar-fixed-top">
                <div class="navbar-inner">
                    <div class="container">

                          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                          </button>

                          <a class="brand" href="<?php echo ABSPATH ?>">TWITTER TIMELINE</a>
                          
                          <div class="nav-collapse collapse">
                              
                                <ul class="nav pull-left">
                                    <li>
                                        <a href="#about-project" data-toggle="modal">About</a>
                                    </li>
                                </ul>
                              
                              <?php if( $twitter->is_authed() ): ?>
                                <ul class="nav pull-right">
                                    <li class="dropdown">
                                        <a data-toggle="dropdown" href="#">
                                            <img src="<?php echo $twitter->user->profile_image_url_https ?>" height="24" width="24">
                                            <?php echo $twitter->user->screen_name ?>
                                            <b class="caret"></b>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li><a href="<?php echo ABSPATH . DS ?>logout.php">Logout</a></li>
                                        </ul>
                                    </li>
                                </ul>
                             <?php endif; ?>
                              
                          </div>
                    </div>
                </div>
          </div>
      </div><!-- end of #header -->
      
      <div id="about-project" class="modal hide fade">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3>About</h3>
            </div>
          
            <div class="modal-body">
                <p>Experimental Project, Go Further at your own risk</p>
            </div>
          
            <div class="modal-footer">
                <a href="https://www.google.com/" data-dismiss="modal" class="btn">Im Afraid</a>
                <a href="#" class="btn btn-primary" data-dismiss="modal">Hide</a>
            </div>
        </div>
 
    <div id="content" class="container-fluid">
        <noscript>
            <div class="alert alert-error">This Page require Javascript Enabled.</div>
        </noscript>