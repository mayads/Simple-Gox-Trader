Simple Gox Trader
=================

This is a trading package written in php for operating on exchange, Mt. Gox. http://mtgox.com


License
-------

    Simple Gox Trader
    Copyright (C) 2011 Mayads

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>


Features
--------

- Ticker display
    - get an overview of your wallet and balances in USD and EURO
    - information about USD and EURO trading infos
    - all your open orders
- Sell bitcoins
    - for now in USD
- Buy bitcoins
- Cancel orders
    - cancel all or one particular


Run
---


### Setup ###
Before you can start trading and watching, you have to get a MT.Gox **Key** 
and **Secret**. You can generate them in on the MT.Gox Website in your profile under 
"Application and API access" in section "Advanced API key creation". Put in a 
name and generate the key.

Now that you got them, open up the file "mtgox_func.php" and fill in your data 
where it says "//<----KEY!" and "//<-SECRET!".

On Windows make sure you have the php executable in your PATH.

On Mac you have to set the "date.timezone" value in the php.ini as admin.


### Starting the programs ###

Just call one of the following:

#### Ticker display ####
	
    php tickerCoins.php

**Options:**

- -i [sec]
    - setting the refresh interval in sec ( remeber MT.Gox has a 10s limit )
- [none]
    - refresh interval is 10s
- -h
    - get the help

#### Sell bitcoins ####
	
    php sellCoins.php

**Options:**

- [amount to sell]
    - amount of bitcoins to sell
- [price]
    - price to sell for in USD
- -h
    - get the help

#### Buy bitcoins ####
	
    php buyCoins.php

**Options:**

- [amount to buy]
    - amount of bitcoins to buy
- [price]
    - price to buy the bitcoins for in USD
- -h
    - get the help

#### Cancel orders ####
	
    php cancelCoins.php

**Options:**

- [oid]
    - order id off the order to cancel
- --all
    - cancel all orders
- -h
    - get the help


Credits
-------

- Mayads <developer@mayads.de>

If you like it, feel free to donate to: 

    1FsYSHSewi47Swc1QjLSMqb3vXchafLxKS