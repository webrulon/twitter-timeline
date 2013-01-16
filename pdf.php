<?php
    
require_once 'init/bootloader.php';

$twitter->only_authed();

$twitter->connect();
$tweet = $twitter->get_tweet(10);

//fpdf
include _LIB . DS . 'fpdf/fpdf.php';

$pdf = new FPDF();
$pdf->AddPage();

$pdf->SetTitle('Tweets');

$pdf->SetFont('Arial','',14);

foreach( $tweet as $t ){
    $pdf->Write(5, $t->text);
    $pdf->ln();
    $pdf->ln();
}

$pdf->Output();