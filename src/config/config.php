<?php

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