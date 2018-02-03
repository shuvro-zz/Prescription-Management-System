<?php    

    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;      
    $PNG_WEB_DIR = 'temp/';

    include "qrlib.php"; 	
    
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
		
    $filename = $PNG_TEMP_DIR.'qr_'.time().'.png';

	QRcode::png("bangladesh", $filename);
    
	//display generated file
    echo '<img src="'.$PNG_WEB_DIR.basename($filename).'" />';

    //QRtools::timeBenchmark();
	
	// Read qrcode
    include "read/qr.php"; 
	echo qrdecode($filename);
    