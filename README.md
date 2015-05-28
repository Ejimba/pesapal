Laravel Pesapal Package
=======================

[![Build Status](https://travis-ci.org/Ejimba/pesapal.svg?branch=master)](https://travis-ci.org/Ejimba/pesapal)
[![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](https://raw.githubusercontent.com/Ejimba/pesapal/master/LICENSE)
[![Latest Version](https://img.shields.io/github/release/ejimba/pesapal.svg?style=flat-square)](https://github.com/ejimba/pesapal/releases)

## Introduction

This is a Laravel pesapal package to integrate Pesapal payments in your application. 

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
php artisan config:publish ejimba/pesapal
```

Then, migrate the package table by using

```php
php artisan migrate --package=ejimba/pesapal
```

Go to your pesapal account and in the ipn url enter

```php
yoursite.com/ipn
```

## Configuration

This is what you should see in the app/config/packages/ejimba/pesapal/config.php

```php
return array(
    
    /*
    |--------------------------------------------------------------------------
    |   Pesapal Activation
    |--------------------------------------------------------------------------
    |
    |   This specifies whether the application is demo or live states.
    |
    |       true => we are live
    |       false => we are in demo
    |
    |   Supported: true, false
    |
    */

    'enabled' => true,

    /*
    |--------------------------------------------------------------------------
    |   Consumer Key
    |--------------------------------------------------------------------------
    |
    |   Consumer key emailed to you when you created a business account
    |   If you don't have one, sign up at https://www.pesapal.com/home/businessindex
    |
    |   Supported: String
    |
    */

    'consumer_key' => "",

    /*
    |--------------------------------------------------------------------------
    |   Consumer Secret
    |--------------------------------------------------------------------------
    |
    |   Consumer secret emailed to you when you created a business account
    |   If you don't have one, sign up at https://www.pesapal.com/home/businessindex
    |
    |   Supported: String
    |
    */

    'consumer_secret' => "",

    /*
    |--------------------------------------------------------------------------
    |   Currency
    |--------------------------------------------------------------------------
    |
    |   Default Currency
    |
    |   Supported: String e.g. KES
    |
    */

    'currency' => "KES",

    /*
    |--------------------------------------------------------------------------
    |   Controller
    |--------------------------------------------------------------------------
    |
    |   This is the controller that will be called if the status is valid,
    |   please note the method that will be called will be updateItem and 
    |   should be static that is update($key,$reference)
    |
    */

    'controller' => "",

    /*
    |--------------------------------------------------------------------------
    |   Key
    |--------------------------------------------------------------------------
    |
    |   Some random key to protect the method from being called elsewhere
    |
    */

    'key'=>"874315",

    /*
    |--------------------------------------------------------------------------
    |   redirectTo
    |--------------------------------------------------------------------------
    |
    |   Where to redirect to - the link to where your thank you page is
    |
    */

    'redirectTo'=>"/",

    /*
    |--------------------------------------------------------------------------
    |   Mail
    |--------------------------------------------------------------------------
    |
    |   Whether to email address upon complete transaction
    |
    */

    'mail' => true,

    /*
    |--------------------------------------------------------------------------
    |   Email
    |--------------------------------------------------------------------------
    |
    |   Your email address where you will be emailed on complete transaction
    |
    */

    'email'=>"",

    /*
    |--------------------------------------------------------------------------
    |   Name
    |--------------------------------------------------------------------------
    |
    |   Your name
    |
    */

    'name'=>"Site Admin",

    /*
    |--------------------------------------------------------------------------
    |   URLs
    |--------------------------------------------------------------------------
    |
    |   URLs for the application's endpoints.
    |
    |   Supported: string
    |
    */

    'url' => array(

        'ipn_demo' => 'http://demo.pesapal.com/api/querypaymentstatus',
        
        'ipn_live' => 'https://www.pesapal.com/api/querypaymentstatus',
        
        'iframe_demo' => 'http://demo.pesapal.com/API/PostPesapalDirectOrderV4',
        
        'iframe_live' => 'https://www.pesapal.com/api/PostPesapalDirectOrderV4',
    
    ),

    /*
    |--------------------------------------------------------------------------
    |   Routing
    |--------------------------------------------------------------------------
    |
    |   Configurations for routing of Pesapal
    |
    */

    'routing' => array(

        /*
        |--------------------------------------------------------------------------
        | Prefix
        |--------------------------------------------------------------------------
        |
        | Prefix for pesapal routes
        |
        |  e.g http://www.domain.com/pesapal/ipn for ipn route, use
        |
        |  'prefix' => 'pesapal'
        */

        'prefix' => '',

        /*
        |--------------------------------------------------------------------------
        | Subdomain
        |--------------------------------------------------------------------------
        |
        | Subdomain for pesapal routes
        |
        |  e.g http://pesapal.domain.com/ipn for ipn route, use
        |
        |  'subdomain' => 'pesapal'
        |
        | Default: Commented out
        |
        */

        // 'subdomain' => 'pesapal.site.com',
    ),

    
    /*
    |--------------------------------------------------------------------------
    |   Views
    |--------------------------------------------------------------------------
    |
    |   Configuration specific to the views used by pesapal.
    |
    */

    'views' => array(

        /*
        |--------------------------------------------------------------------------
        |   Successful Payment Email View
        |--------------------------------------------------------------------------
        |
        |   View used to render the email after successfull processing a payment
        | 
        |   To use your own email view, replace the view name here.
        |
        |   e.g To use app/views/emails/payment.blade.php:
        |
        |   'payment_email' => 'emails.payment'
        */

        'payment_email' => 'pesapal::emails.payment',

    ),

);
```

## Usage

After configuration, you should be able to call

```php
Pesapal::Iframe($dataArray)
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

## License

Laravel Auto Presenter is licensed under [The MIT License (MIT)](LICENSE).