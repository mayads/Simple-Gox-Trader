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
	" .$argv[0]. " <amount to sell> <price> [<currency>]

	<amount to sell>    BTC value to sell
	<price>		    price
	<currency>	    currency to sell in, default is '".loadSingleton('MTConfig')->defaultCurrency."'
			    possible values are: 
				USD, EUR, JPY, CAD, GBP, CHF, RUB, AUD,
				SEK, DKK, HKD, PLN, CNY, SGD, THB, NZD
	With the --help, -help, -h, or -? options, you 
	can get this help.
";
}


function main($amount, $price, $currency, $wait )
{
    echo "PRICE: $price $currency AMOUNT: $amount\n"; 
    echo "SELLING Bit coins to cancel transaction hit Ctrl C\n"; 
    sleep($wait);
    $decoded = SellBTC($amount, $price, $currency);
    
    if ( isset($decoded['status']) ) {
	echo "Printing orders\n";
	
	$mtOrders = new MTOrders();
	$mtOrders->setData($decoded);
	echo $mtOrders->printOrders(0.6);
    }
}

if ( $argc < 3 || $argc > 4 )
{
    printHelp($argv);
}
elseif ( in_array($argv[1], array('--help', '-help', '-h', '-?'))) {
    printHelp($argv);
}
elseif ( $argc === 3 ) {
    $amount= $argv[1];
    $price = $argv[2];
    main($amount, $price, loadSingleton('MTConfig')->defaultCurrency, loadSingleton('MTConfig')->defaultCancelwait );
}
elseif ($argc === 4) {
    $amount= $argv[1];
    $price = $argv[2];
    $currency = $argv[3];
    main($amount, $price, $currency, loadSingleton('MTConfig')->defaultCancelwait );
}
else {
    printHelp($argv);
}
?>
