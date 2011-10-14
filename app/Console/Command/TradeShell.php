<?php
class TradeShell extends AppShell {
    
    // override to display another welcome message
    public function startup() {
	$this->out('SimpleGoxTrader v2.0');
    }
    
    public function main() {
        $this->out('Hello world.');
    }
    
    
    // any functions not _ prefixed can be called as task
    public function _hey_there() {
        $this->out('Hey there ' . $this->args[0]);
    }
}