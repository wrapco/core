A custom module for [wrapco.com.au](https://wrapco.com.au) and [inkyco.com.au](https://inkyco.com.au)

## How to install
```
bin/magento maintenance:enable
composer clear-cache
composer require wrapco/core:*
bin/magento setup:upgrade
rm -rf var/di var/generation generated/code && bin/magento setup:di:compile
rm -rf pub/static/* && bin/magento setup:static-content:deploy -f en_US en_AU
bin/magento maintenance:disable
```

## How to upgrade
```
bin/magento maintenance:enable
composer clear-cache && composer update wrapco/core && composer clear-cache && composer update wrapco/core && composer clear-cache && composer update wrapco/core
bin/magento setup:upgrade
rm -rf var/di var/generation generated/code && bin/magento setup:di:compile
rm -rf pub/static/* && bin/magento setup:static-content:deploy -f en_US en_AU
bin/magento maintenance:disable
```

If you have problems with these commands, please check the [detailed instruction](https://mage2.pro/t/263).