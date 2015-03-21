Laravel Pesapal Package
=======================

[![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](https://raw.githubusercontent.com/Ejimba/pesapal/master/LICENSE)

## Introduction

This is a Laravel pesapal package to integrate Pesapal payments in your application. Pesapal do not have a way to test this so I guess you will have to send money payments to test.

## Installation

You should install this package with [Composer](http://getcomposer.org/). Add the following "require" to your `composer.json` file and run the `composer install` command to install it.

##### Laravel 5

Coming soon

##### Laravel 4.2

```json
{
    "require": {
        "ejimba/pesapal": "2.x"
    }
}
```

##### Laravel 4.1

```json
{
    "require": {
        "ejimba/pesapal": "1.x"
    }
}
```

Then, in your `app/config/app.php` add this line to your 'providers' array.

```php
'Ejimba\Pesapal\PesapalServiceProvider',
```

Then, publish the config file by

```php
php artisan config:publish ejimba/pesapal,
```

Then, migrate the package table by using

```php
php artisan migrate --package=ejimba/pesapal,
```

Go to your pesapal account and in the ipn url enter

```php
yoursite.com/listenipn,
```

## Configuration

This is what you should see in the app/config/packages/ejimba/pesapal/config.php

```php
return array(
    
    //enable/disable pesapal

    'enabled' => true, 
    
    // Consumer key emailed to you when you created a business account
    // If you don't have one, sign up at https://www.pesapal.com/home/businessindex

    'consumer_key' => "",
    
    // Consumer secret emailed to you when you created a business account
    // If you don't have one, sign up at https://www.pesapal.com/home/businessindex
    
    'consumer_secret'=>"",

    // This is the controller action that will be called if the status is valid,
    // please note the method that will be called will be updateItem and should be
    // static that is update($key,$reference)
    
    'controller'=>"YourController",

    // key to protect the method from being called elsewhere

    'key'=>"12345",

    // the link to where your thankyou page is

    'redirectTo'=>"/",

    // whether to send email or not

    'mail'=>true,

    // email address where you will be emailed upon complete transaction

    'email'=>"your@email.com",

     // name for email sending purposes

    'name'=>"Admin",
    
    // default currency

    'currency' => "KES",

);
```

## Usage

After configuration, you should be able to call

```php
Pesapal::Iframe($dataArray),
```
from any view you would like the payment iframe to appear.

The array should have the following info:

```php
$dataArray = array(
    'description' => 'Description of the item or service',
    'currency' => 'If set will override the currency config settings',
    'user' => 'Client user id if you have a system of users',
    'first_name' => 'First name of the user that is paying',
    'last_name' => 'Last name of the user that is paying',
    'email' => 'Valid email of the user that is paying',
    'phone_number' => 'Optional if email has been specified';
    'amount' => 'Amount to be charged',
    'reference' => 'Unique key to the transaction',
    'type' => 'default is MERCHANT',
    'frame_height' => 'Height of the iframe. Please provide integers as in 900 without the px'
);
```