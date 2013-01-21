<?php

require_once 'init/bootloader.php';
$twitter->only_authed();

//load fpdf library
include _LIB . DS . 'fpdf/fpdf.php';

$pdf = new FPDF();

//some fancy thing
$pdf->AddPage();
$pdf->SetTitle('Tweets');
$pdf->SetFont('Arial','',14);

//check if screen_name is supplied
if( empty( $_REQUEST['screen_name'] ) ):
    
    $pdf->Write(5, "Its Look like you forgot to mention the screen_name." );
    
else:
    
    //loading the tweets
    $screen_name = (string)$_REQUEST['screen_name'];
    $tweet = $twitter->get_tweet(10, $screen_name);

    //did an error occured in loading tweets
    if( isset( $tweet->error ) ):

        $pdf->Write(5, "Oops, An Error Occured." );
        $pdf->ln();
        $pdf->ln();
        $pdf->Write(5,  "Twitter says " . $tweet->error);

    else:

        //no , we are working perfectly
        foreach( $tweet as $t ){
            $pdf->Write(5, $t->text);
            $pdf->ln();
            $pdf->ln();
        }
    endif;
    
endif;


//print the pdf
$pdf->Output();