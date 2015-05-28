<?php

namespace Ejimba\Pesapal;

use Illuminate\Database\Eloquent\Model;

class Pesapalpayments extends Model {
       public $table = "pesapalpayments";
       protected $fillable = ['tracking_id','payment_method',
           'description',
           'currency',
           'user',
           'first_name',
           'last_name',
           'email',
           'phone_number',
           'amount',
           'reference',
           'type',
           'enabled',
           'updated_at',
       ];
} 