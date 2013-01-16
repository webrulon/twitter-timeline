<?php
    
require_once 'init/bootloader.php';

$twitter->only_authed();

include _LIB . DS . 'fpdf/fpdf.php';

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetTitle('Tweets');

$twitter->connect();
$tweet = $twitter->get_tweet(10);

foreach( $tweet as $t ){
    $pdf->Write(5, $t->text);
}

$pdf->Output();