<?php 
class MTConfig
{
	public $mtgox_key= '';      //<----KEY! 
	public $mtgox_secret= '';   //<-SECRET!

	// default settings for trading
	public $defaultCurrency = 'EUR';

	// wait before sending request to mtgox
	public $defaultCancelwait = 5;

	public $refreshTime = 10; 
}
?>
