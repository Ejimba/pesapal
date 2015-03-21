<?php

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