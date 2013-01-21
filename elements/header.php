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
 
      <noscript>
        <div class="alert alert-error">This Page require Javascript Enabled.</div>
      </noscript>
      
      <div id="header">
          <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">

                      <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                      </button>

                      <a class="brand" href="./index.html">Twitter Timeline</a>
                      <div class="nav-collapse collapse">
                          <ul class="nav">
                              <li class="pull-right">
                                  <a title="Experimental Project, Go Further at your own risk" href="javascript:alert(this.title)">About</a>
                              </li>
                              <?php if( ! $twitter->is_unauthed() ): ?>
                              <li class="pull-right">
                                  <a href="<?php echo ABSPATH . DS ?>logout.php">Logout</a>
                              </li>
                              <?php endif; ?>
                          </ul>
                      </div>
                </div>
            </div>
          </div>
      </div><!-- end of #header -->
      
      <div id="content">