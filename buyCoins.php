<?php
    
// instance loader
include_once './class_loader.php';
// mtgox functions
include_once "./mtgox_func.php";
    

function printHelp($argv)
{
    echo 
    "Buy Coins at mtgox.com Script.
	Usage:
	" .$argv[0]. " <amount to buy> <price>

	<amount to buy>    BTC value to buy
	<price>		   price in USD
	With the --help, -help, -h, or -? options, you 
	can get this help.
";
}

if ( count($argv) != 3 || in_array($argv[1], array('--help', '-help', '-h', '-?'))) {
    printHelp($argv);
}
elseif ( count($argv) === 3 ) {
    $amount= $argv[1];
    $price = $argv[2];
    
    echo "PRICE: $price AMOUNT: $amount\n"; 
    echo "BUYING Bit coins to cancel transaction hit Ctrl C\n"; 
    sleep(5);
    $req=array('amount'=>$amount,'price'=>$price); 
    $decoded=mtgox_query('0/buyBTC.php',$req); 
    
    if ( isset($decoded['status']) ) {
	echo "Printing orders\n";
	
	$mtOrders = new MTOrders();
	$mtOrders->setData($decoded);
	echo $mtOrders->printOrders(0.6);
    }
    
}
?>
