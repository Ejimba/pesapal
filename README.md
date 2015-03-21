Laravel Pesapal Package
=======================

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

Then, in your `config/app.php` add this line to your 'providers' array.

```php
'Ejimba\Pesapal\PesapalServiceProvider',
```

Then, publish the config file by

```php
'php artisan config:publish ejimba/pesapal',
```

Then, migrate the package table by using

```php
'php artisan migrate --package=ejimba/pesapal',
```

Go to your pesapal account and in the ipn url enter

```php
'yoursite.com/listenipn',
```

<h2>Configuration</h2>
This is what you should see in the app/packages/ejimba/pesapal/config.php
<pre>
/**
 * this settings are needed in order to work with pesapal
 * enabled(bool) -if true sets the pesapal to live instead of demo website that was not functioning at the time of writing this package
 * consumer_key the consumer key gotten from the pesapal website
 * consumer_secret- The consumer secret gotten from the pesapal website
 * controller - This is the controller that will be called if the status is valid,
 * please note the method that will be called will be updateItem and should be static that is update($key,$reference)
 * Key- the key to protect the method from being called elsewhere
 * redirectTo - the link to where your thankyou page is
 * email - Your email address where you will be emailed on complete transaction
 * name - your name
 * currency - the currency that will be used on payment
 *
 */
return array(

    'enabled' => true,
    'consumer_key' => "",
    'consumer_secret'=>"",
    'controller'=>"YourController",
    'key'=>"12345",
    'redirectTo'=>"/",
    'email'=>"your@email.com",
    'mail'=>true,
    'name'=>"Admin",
    'currency'=>"KES",

);
</pre>
You are now set once the right info is entered.
<h2>How to use</h2>
Now you should be able to call the <pre>Pesapal::Iframe($array)</pre>
from any view you would like the iframe to appear.
The array should have this info in the <pre>$array</pre>
  <pre>/**
     * generates the iframe from the given details
     * @param array $values this array should contain the fields required by pesapal
     * description - description of the item or service
     * currency - if set will override the config settings you have of currency
     * user -which should be your client user id if you have a system of users
     * first_name- the first name of the user that is paying
     * last_name - the last name of the user that is paying
     * email - this should be a valid email or pesapal will throw an error
     * phone_number -which is option if you have the email
     * amount - the total amount to be posted to pesapal
     * reference Please <em>Make sure this is a unique key to the transaction</em>. <em>An example is the id of the item or something</em>
     * type - default is MERCHANT
     * frame_height- this is the height of the iframe please provide integers as in 900 without the px
     *
     */'
     </pre>
