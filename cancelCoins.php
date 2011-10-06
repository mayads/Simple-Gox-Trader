<?php
    
// instance loader
include_once './class_loader.php';
// mtgox functions
include_once "./mtgox_func.php";
    

function printHelp($argv)
{
    echo 
    "Cancel orders at mtgox.com Script.
	Usage:
	" .$argv[0]. " --all | <oid>

	--all    cancel all orders at once
	<oid>	 cancel order with <oid>
	With the --help, -help, -h, or -? options, you 
	can get this help.
";
}

if ( $argc != 2 || in_array($argv[1], array('--help', '-help', '-h', '-?'))) {
    printHelp($argv);
}
elseif ( $argc === 2 && $argv[1] == "--all" ) {
    
    echo "Canceling all orders. Stop action with Ctrl C\n"; 
    sleep(5);
    
    $orders = GetOrders('USD');
    
    foreach ($orders->orders as $order) {
	$req=array('oid'=>$order->oid,'type'=>$order->type); 
	$decoded=mtgox_query('0/cancelOrder.php',$req);
	
	echo "Order with oid " .$order->oid. " canceled\n";
    }
}
else {
    $oid = $argv[1];
    echo "Cancel order with oid " .$oid. " Stop it with Ctrl C\n";
    sleep(5);
    
    $orders = GetOrders('USD');
    
    $foundOrder = $orders->findOrder($oid);
    if ( $foundOrder === NULL ) {
	echo "Order with oid " .$oid. " not found.\n";
	exit;
    }
    
    $req=array('oid'=>$oid,'type'=>$foundOrder->type); 
    $decoded=mtgox_query('0/cancelOrder.php',$req);
    
    $newOrders = new MTOrders();
    $newOrders->setData($decoded);
    echo $newOrders->printOrders(0.6);
}
?>
