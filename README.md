# Laravel-blockchain-data-api
This is a laravel package for interacting with blockchain data api 

# laravel-blockchain

> A Laravel 5 Package for working with blockchain data api

## Installation

[PHP](https://php.net) 5.4+ or [HHVM](http://hhvm.com) 3.3+, and [Composer](https://getcomposer.org) are required.

To get the latest version of blockchain data api, simply run the code below in your project.

```
"composer require waygodd/blockchaindata"
```
Once Laravel Blockchain Data is installed, You need to register the service provider. Open up `config/app.php` and add the following to the `providers` key.

* `Waygood\BlockchainData\BlockchainDataServiceProvider::class,`

Also, register the Facade like so:

```php
'aliases' => [
    ...
    'BlockchainData' => Waygood\BlockchainData\Facades\BlockchainData::class,
    ...
]
```


## USING /WAYGOOD/BLOCKCHAINDATA PACKAGE 
```
Add the following line to your controller

use BlockchainData
```

## 1. GET SINGLE BLOCK
optional $format JSON by default, alternatively HEX
```php
$block = BlockchainData::getBlock($block_hash[, $format]);
```


## 2. GET SINGLE TRANSACTION
optional $format JSON by default, alternatively HEX
```php
$tx = BlockchainData::getTransaction($tx_hash[, $format]);
```


## 3. GET STATISTICS CHART
```php
$chart = BlockchainData::getChart($chart_type);
```


## 4. BLOCKS AT HEIGHT
```php
$blocks = BlockchainData::blocksAtHeight($height);
```


## 5. GET ADDRESS CONTENTS
$bitcoin_address contains multiple addresses divided by |
Optional limit parameter to show n transactions e.g. &n=50 (Default: 50, Max: 100)
Optional offset parameter to skip the first n transactions e.g. &offset=100 (Page 2 for limit 50)
```php
$blocks = BlockchainData::getAddress($bitcoin_address[, $limit[, $offset]]);
```


## 6. UNSPENT OUTPUTS
$bitcoin_address contains multiple addresses divided by |
Optional limit parameter to show n transactions e.g. &n=50 (Default: 50, Max: 100)
Optional offset parameter to skip the first n transactions e.g. &offset=100 (Page 2 for limit 50)
```php
$blocks = BlockchainData::unspentAddress($bitcoin_address[, $limit[, $offset]]);
```


## 7. BALANCE
$bitcoin_address contains multiple addresses divided by |
```php
$blocks = BlockchainData::balanceAddress($bitcoin_address[, $limit[, $offset]]);
```


## 8. LATEST BLOCK
```php
$blocks = BlockchainData::latestBlock();
```


## 9. UNCONFIRMED TRANSACTIONS
```php
$blocks = BlockchainData::unconfirmedTransactions();
```


## 10. DAILY BLOCKS
```php
$blocks = BlockchainData::dailyBlocks($timestamp);
```


## 10. DAILY BLOCKS
```php
$blocks = BlockchainData::poolBlocks($pool_name);
```


## Credit 
Readme document was inpsired and tuned from one of @Unicodedeveloper. Prosper Otemuyiwa.

## Contributing

Please feel free to fork this package and contribute by submitting a pull request to enhance the functionalities.

## How can I thank you?

Why not star the github repo? I'd love the attention! Why not share the link for this repository on Twitter or HackerNews? Spread the word!


Thanks!
Matthew Waygood

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

