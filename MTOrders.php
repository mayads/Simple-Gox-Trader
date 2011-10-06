<?php

/**
 * Description of MTOrder
 *
 * @author mayads
 */
class MTOrder {
    public $oid;
    public $type;
    public $amount;
    public $item; // normal 'BTC'
    public $status;
    public $currency;
    public $price;
    public $date;

    public function __construct($order) {
	$this->oid = $order['oid'];
	$this->type = $order['type']; // 1=>sell, 2=> buy
	$this->amount = $order['amount'];
	$this->item = $order['item'];
	$this->status = $order['status'];
	$this->currency = $order['currency'];
	$this->price = $order['price'];
	$this->date = new DateTime;
	$this->date->setTimestamp($order['date']);
    }
    
    public function statusOk() {
	return $this->status === 1; // active
    }
    
    public function statusOkString() {
	return ( $this->status === 1 ? "" : "(INV)");
    }


    public function typeString() {
	return ($this->type == 1 ? 'sell' : 'buy' );
    }
}

/**
 * Description of MTOrders
 *
 * @author mayads
 */
class MTOrders {
    public $orders = array();


    public function __construct() {
    }

    public function setData($orders) {
	//reset array
	unset($this->orders);
	$this->orders = array();
	foreach ($orders['orders'] as $order) {
	    $objOrder = new MTOrder($order);
	    $this->orders[] = $objOrder;
	}
    }
    
    public function printOrders( $fee )
    {
	$ret = '';

	foreach ($this->orders as $value) {
	    $ret .= $value->statusOkString(). " " .$value->typeString(). " " .$value->amount. " BTC for " .$value->price. " " .$value->currency. " ( " .$value->amount*$value->price * ( $value->type === 1 ? 1 - ($fee/100) : 1 )." )";
	    
	    if ( $value->type === 2 ) {
		// minimum sell price == 2*fee * price
		$ret .= " min sell " . (2*($fee/100) + 1)*$value->price;
	    }
	    $ret .= "\n\t". $value->oid. "\n";
	}
	
	return $ret;
    }
    
    public function findOrder($oid) {
	foreach ($this->orders as $order) {
	    if ( $order->oid === $oid ) {
		return $order;
	    }
	}
	
	return NULL;
    }
}

?>
