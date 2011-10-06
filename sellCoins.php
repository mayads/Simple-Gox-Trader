<?php
    
// instance loader
include_once './class_loader.php';
// mtgox functions
include_once "./mtgox_func.php";
    

function printHelp($argv)
{
    echo 
    "Sell Coins at mtgox.com Script.
	Usage:
	" .$argv[0]. " <amount to sell> <price>

	<amount to sell>    BTC value to sell
	<price>		    price in USD
	With the --help, -help, -h, or -? options, you 
	can get this help.
";
}

if ( $argc != 3 || in_array($argv[1], array('--help', '-help', '-h', '-?'))) {
    printHelp($argv);
}
elseif ( $argc === 3 ) {
    $amount= $argv[1];
    $price = $argv[2];
    
    echo "PRICE: $price AMOUNT: $amount\n"; 
    echo "SELLING Bit coins to cancel transaction hit Ctrl C\n"; 
    sleep(5);
    $req=array('amount'=>$amount,'price'=>$price); 
    $decoded=mtgox_query('0/sellBTC.php',$req); 
    
    if ( isset($decoded['status']) ) {
	echo "Printing orders\n";
	
	$mtOrders = new MTOrders();
	$mtOrders->setData($decoded);
	echo $mtOrders->printOrders(0.6);
    }
}
?>
