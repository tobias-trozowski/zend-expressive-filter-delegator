# zend-expressive-filter-delegator

[![License](https://poser.pugx.org/tobias/zend-expressive-filter-delegator/license)](https://packagist.org/packages/tobias/zend-expressive-filter-delegator)
[![Latest Stable Version](https://poser.pugx.org/tobias/zend-expressive-filter-delegator/v/stable)](https://packagist.org/packages/tobias/zend-expressive-filter-delegator)
[![PHP 7 ready](http://php7ready.timesplinter.ch/tobias-trozowski/zend-expressive-filter-delegator/badge.svg)](https://travis-ci.org/tobias-trozowski/zend-expressive-filter-delegator)
[![Build Status](https://travis-ci.org/tobias-trozowski/zend-expressive-filter-delegator.svg?branch=master)](https://travis-ci.org/tobias-trozowski/zend-expressive-filter-delegator)
[![Coverage Status](https://coveralls.io/repos/tobias-trozowski/zend-expressive-filter-delegator/badge.svg?branch=master)](https://coveralls.io/r/tobias-trozowski/zend-expressive-filter-delegator?branch=master)
[![Total Downloads](https://poser.pugx.org/tobias/zend-expressive-filter-delegator/downloads)](https://packagist.org/packages/tobias/zend-expressive-filter-delegator)

Delegator for Zend [FilterPluginManager](https://github.com/zendframework/zend-filter)

This package provides a delegator for the FilterPluginManager which configures the PluginManager to use the service configuration from ```filters``` from your config.

The package is intended to be used with [Zend Expressive Skeleton](https://github.com/zendframework/zend-expressive-skeleton) or any other [Zend Expressive](https://github.com/zendframework/zend-expressive) application.


## Installation

The easiest way to install this package is through composer:

```bash
$ composer require tobias/zend-expressive-filter-delegator
```

## Configuration

In the general case where you are only using a single connection, it's enough to define the delegator factory for the FilterManager:

```php
return [
    'dependencies' => [
        'delegators' => [
            'FilterManager' => [
                \Tobias\Expressive\Filter\FilterManagerDelegatorFactory::class,
            ],
        ],
    ],
];
```

### Using Expressive Config Manager

If you're using the [Expressive Config Manager](https://github.com/mtymek/expressive-config-manager) you can easily add the ConfigProvider class.

```php
$configManager = new ConfigManager(
    [
        \Tobias\Expressive\Filter\ConfigProvider::class,
    ]
);
```