<?php

/**
 * Description of MTCurrency
 *
 * @author mayads
 */
class MTCurrency
{
    public $currency;
    public $doubleValue;
    public $displayString;
}

/**
 * Description of MTInfo
 *
 * @author mayads
 */
class MTInfo {
    public $btcCount;
    public $usdCount;
    public $eurCount;
    public $fee;
    
    public function __construct()
    {
	$this->btcCount = new MTCurrency();
	$this->eurCount = new MTCurrency();
	$this->usdCount = new MTCurrency();
	$this->fee = 0.6;
    }


    public function loadData()
    {
	$decodeInfo = GetInfo('EUR');
	
	$this->btcCount->currency = $decodeInfo['Wallets']['BTC']['Balance']['currency'];
	$this->btcCount->doubleValue = $decodeInfo['Wallets']['BTC']['Balance']['value'];
	$this->btcCount->displayString = $decodeInfo['Wallets']['BTC']['Balance']['display'];
	
	$this->eurCount->currency = $decodeInfo['Wallets']['EUR']['Balance']['currency'];
	$this->eurCount->doubleValue = $decodeInfo['Wallets']['EUR']['Balance']['value'];
	$this->eurCount->displayString = $decodeInfo['Wallets']['EUR']['Balance']['display'];
	
	$this->usdCount->currency = $decodeInfo['Wallets']['USD']['Balance']['currency'];
	$this->usdCount->doubleValue = $decodeInfo['Wallets']['USD']['Balance']['value'];
	$this->usdCount->displayString = $decodeInfo['Wallets']['USD']['Balance']['display'];
	
	$this->fee = $decodeInfo['Trade_Fee'];
    }
    
    public function printTotals() {
	echo "TOTALS: " .$this->btcCount->displayString. ", ";
	echo $this->usdCount->displayString. ", "; 
	echo $this->eurCount->displayString. ", ";
	echo "Fee " .$this->fee. "\n\n"; 
    }
}

?>
