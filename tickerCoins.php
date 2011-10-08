<?php

// instance loader
include_once './class_loader.php';
// mtgox functions
include_once "mtgox_func.php";
include_once "MTInfo.php";
    

function printHelp($argv)
{
    echo 
    "Bitcoin ticker for mtgox.com data.
	Usage:
	" .$argv[0]. " [-i <sec>]

	no option	ticker interval 10 seceonds
	-i <sec>	set ticker interval to <sec> seconds
	With the --help, -help, -h, or -? options, you 
	can get this help.
";
}

if ( count($argv) === 2 && in_array($argv[1], array('--help', '-help', '-h', '-?'))) {
    printHelp($argv);
}
 elseif ( $argc === 2 && $argv[1] === '-t' ) {

     echo "history USD
";
     $decoded = GetHistory('USD');
     
    $Data = str_getcsv($decoded, "\n"); //parse the rows
    //var_dump($Data);
    foreach($Data as $Row) 
	$Rows[] = str_getcsv($Row, ","); //parse the items in rows 
 
     var_dump($Rows);
}
else if ( $argc === 3 && $argv[1] === '-i' ) {
	main( $argv[2] );
}
else {
	main( 10 );
}



function main( $wait )
{ // normal programm

    // there is a 10 seconds cache on the mtgox server site, no need to pull 
    // more then that  time frame, otherwise we could get banned
    $seconds_wait = $wait;    

    
    while(TRUE){ 
	$mtInfo = new MTInfo();
	$mtInfo->loadData();
	$decodedEUR=GetMtGoxData('EUR');
	$decoded=GetMtGoxData('USD');
	$objOrders= GetOrders('USD');
	echo date('l jS \of F Y h:i:s A')."\n"; 

	$mtInfo->printTotals();

	echo "LAST:\t\t".$cur_last=$decoded['ticker']['last']. "\t\t" .$decodedEUR['ticker']['last']. " EURO\n";
	echo "BUY:\t\t".$cur_buy=$decoded['ticker']['buy']. "\t\t" .$decodedEUR['ticker']['buy']. " EURO\n";
	echo "SELL:\t\t".$cur_sell=$decoded['ticker']['sell']. "\t\t" .$decodedEUR['ticker']['sell']. " EURO\n";
	echo "HIGH:\t\t".$cur_high=$decoded['ticker']['high']. "\t\t" .$decodedEUR['ticker']['high']. " EURO\n";
	echo "LOW:\t\t".$cur_low=$decoded['ticker']['low']. "\t\t" .$decodedEUR['ticker']['low']. " EURO\n";
	echo "AVERAGE:\t".$cur_avg=$decoded['ticker']['avg']. "\t" .$decodedEUR['ticker']['avg']. " EURO\n";
	echo "VWAP:\t\t".$cur_vwap=$decoded['ticker']['vwap']. "\t" .$decodedEUR['ticker']['vwap']. " EURO\n\n";
	echo "Open Orders:\n";
	echo $objOrders->printOrders($mtInfo->fee);
	
	// fill the screen up to 24 lines
	for ($i = 0; $i < (10 - count($objOrders->orders)*2); ++$i) {
		echo "--\n";
	}
	sleep($seconds_wait);
    }
}
?>
