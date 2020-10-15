# extensions-customer-pricing
    This module allow you can configure specific price of product for specific customer 

## Installation
    Go to root folder and run command
        composer require extensions/customer-pricing
        php bin/magento setup:upgrade
        php bin/magento module:enable Extensions_CustomerPricing
        
## Command
    Full Reindex
        php bin/magento indexer:reindex customer_product_price_flat
        
## Changelog
    * 1.0.0  - Initial module
